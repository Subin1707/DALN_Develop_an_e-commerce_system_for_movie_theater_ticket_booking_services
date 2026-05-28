<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /* ===================== ADMIN / STAFF LIST ===================== */
    public function index()
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $bookings = Booking::with(['showtime.movie', 'user'])
            ->latest()
            ->paginate(10);

        // ✅ VIEW PHÂN THEO ROLE (BẮT BUỘC PHẢI TỒN TẠI)
        return Auth::user()->role === 'admin'
            ? view('bookings.admin.index', compact('bookings'))
            : view('bookings.staff.index', compact('bookings'));
    }

    /* ===================== USER HISTORY ===================== */
    public function history()
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $bookings = Booking::where('user_id', Auth::id())
            ->with(['showtime.movie', 'showtime.room'])
            ->latest()
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    /* ===================== CHOOSE SHOWTIME ===================== */
    public function chooseShowtime(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $query = Showtime::with(['movie', 'room'])
            ->where('start_time', '>=', now());

        if ($request->filled('search')) {
            $query->whereHas('movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        return view('bookings.choose', compact('showtimes'));
    }

    /* ===================== CREATE ===================== */
    public function create(Showtime $showtime)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        if ($showtime->start_time < now()) {
            return redirect()
                ->route('bookings.choose')
                ->with('error', 'Suất chiếu này đã qua giờ, vui lòng chọn suất chiếu khác.');
        }

        $occupiedSeats = Booking::where('showtime_id', $showtime->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->flatMap(fn ($s) => explode(',', $s))
            ->map(fn ($s) => trim($s))
            ->toArray();

        return view('bookings.create', compact('showtime', 'occupiedSeats'));
    }

    /* ===================== PAYMENT PREVIEW ===================== */
    public function paymentPreview(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required|string',
        ]);

        $showtime = Showtime::with(['movie', 'room'])
            ->findOrFail($request->showtime_id);

        if ($showtime->start_time < now()) {
            return redirect()
                ->route('bookings.choose')
                ->with('error', 'Suất chiếu này đã qua giờ, vui lòng chọn suất chiếu khác.');
        }

        $seats = $this->normalizeSeats($request->seats);
        abort_if(empty($seats), 422, 'Vui long chon it nhat 1 ghe.');

        $invalidSeats = $this->invalidSeats($showtime, $seats);
        abort_if(!empty($invalidSeats), 422, 'Ghe khong hop le: ' . implode(', ', $invalidSeats));

        $occupiedSeats = $this->occupiedSeatsForShowtime($showtime->id);
        $duplicatedSeats = array_values(array_intersect($seats, $occupiedSeats));
        if (!empty($duplicatedSeats)) {
            return redirect()
                ->route('bookings.create', $showtime)
                ->with('error', 'Ghe da duoc dat: ' . implode(', ', $duplicatedSeats) . '. Vui long chon ghe khac.');
        }

        $totalPrice = count($seats) * $showtime->price;

        return view('bookings.payment', compact(
            'showtime',
            'seats',
            'totalPrice'
        ));
    }

    public function paymentPreviewResume(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $oldInput = $request->session()->getOldInput();

        if (!empty($oldInput['showtime_id']) && !empty($oldInput['seats'])) {
            $resumeRequest = Request::create(
                route('bookings.payment.preview', [], false),
                'POST',
                [
                    'showtime_id' => $oldInput['showtime_id'],
                    'seats' => $oldInput['seats'],
                ]
            );

            return $this->paymentPreview($resumeRequest);
        }

        return redirect()
            ->route('bookings.choose')
            ->withErrors(['booking' => 'Vui long chon suat chieu va ghe truoc khi thanh toan.']);
    }

    /* ===================== STORE ===================== */
    public function store(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,id',
            'seats'          => 'required|string',
            'payment_method' => 'required|in:cash,transfer,online',
        ]);

        if ($request->payment_method === 'online' && !$this->isMomoConfigured()) {
            return redirect()
                ->route('bookings.payment.preview')
                ->withInput()
                ->withErrors(['payment_method' => 'Chua cau hinh MoMo UAT. Vui long them MOMO_PARTNER_CODE, MOMO_ACCESS_KEY va MOMO_SECRET_KEY trong file .env.']);
        }

        $showtime = Showtime::with('room')->findOrFail($request->showtime_id);
        abort_if($showtime->start_time < now(), 403);

        $selectedSeats = $this->normalizeSeats($request->seats);
        abort_if(empty($selectedSeats), 422, 'Vui long chon it nhat 1 ghe.');

        $invalidSeats = $this->invalidSeats($showtime, $selectedSeats);
        abort_if(!empty($invalidSeats), 422, 'Ghe khong hop le: ' . implode(', ', $invalidSeats));

        $booking = DB::transaction(function () use ($request, $showtime, $selectedSeats) {
            Showtime::whereKey($showtime->id)->lockForUpdate()->first();

            $occupiedSeats = Booking::where('showtime_id', $showtime->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate()
                ->pluck('seats')
                ->flatMap(fn ($seats) => explode(',', $seats))
                ->map(fn ($seat) => trim($seat))
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            $duplicatedSeats = array_values(array_intersect($selectedSeats, $occupiedSeats));
            if (!empty($duplicatedSeats)) {
                return [
                    'duplicatedSeats' => $duplicatedSeats,
                ];
            }

            return Booking::create([
                'user_id'        => Auth::id(),
                'showtime_id'    => $showtime->id,
                'room_code'      => $showtime->room->name ?? null,
                'seats'          => implode(',', $selectedSeats),
                'total_price'    => count($selectedSeats) * $showtime->price,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);
        });

        if (is_array($booking) && !empty($booking['duplicatedSeats'])) {
            return redirect()
                ->route('bookings.create', $showtime)
                ->with('error', 'Ghe da duoc dat: ' . implode(', ', $booking['duplicatedSeats']) . '. Vui long chon ghe khac.');
        }

        if ($booking->payment_method === 'online') {
            return redirect()->away($this->createMomoPaymentUrl($booking));
        }

        if ($booking->payment_method === 'transfer') {
            return redirect()->route('bookings.transfer.demo', $booking);
        }

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', '🎟️ Đặt vé thành công!');
    }

    public function momoReturn(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        if (!$this->hasValidMomoSignature($request->query())) {
            return redirect()
                ->route('bookings.history')
                ->withErrors(['payment' => 'Chu ky thanh toan MoMo khong hop le.']);
        }

        $booking = Booking::where('booking_code', $request->query('orderId'))
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return $this->completeMomoPayment($booking, (array) $request->query(), true);
    }

    public function retryOnlinePayment(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->payment_method !== 'online', 404);
        abort_if($booking->status !== 'pending', 409);
        abort_if($booking->showtime->start_time < now(), 403);

        if (!$this->isMomoConfigured()) {
            return back()
                ->withErrors(['payment' => 'Chua cau hinh MoMo UAT. Vui long them MOMO_PARTNER_CODE, MOMO_ACCESS_KEY va MOMO_SECRET_KEY trong file .env.']);
        }

        return redirect()->away($this->createMomoPaymentUrl($booking));
    }

    public function showBankTransferDemo(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->payment_method !== 'transfer', 404);
        abort_if($booking->showtime->start_time < now(), 403);

        if ($booking->status === 'confirmed') {
            return redirect()->route('bookings.show', $booking);
        }

        abort_if($booking->status !== 'pending', 409);

        $booking->load(['showtime.movie', 'showtime.room']);

        return view('bookings.transfer-demo', compact('booking'));
    }

    public function completeBankTransferDemo(Booking $booking, Request $request)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->payment_method !== 'transfer', 404);
        abort_if($booking->status !== 'pending', 409);

        $request->validate([
            'result' => 'required|in:success,failed',
            'bank_reference' => 'required_if:result,success|nullable|string|max:255',
        ]);

        if ($request->result === 'failed') {
            $booking->update([
                'status' => 'cancelled',
            ]);

            return redirect()
                ->route('bookings.history')
                ->withErrors(['payment' => 'Chuyen khoan that bai. Ve da duoc huy de nha ghe.']);
        }

        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Da xac nhan chuyen khoan. Ve da duoc dat thanh cong.');
    }

    public function momoIpn(Request $request)
    {
        $payload = $request->all();

        if (!$this->hasValidMomoSignature($payload)) {
            return response()->json([
                'resultCode' => 97,
                'message' => 'Invalid signature',
            ]);
        }

        $booking = Booking::where('booking_code', $payload['orderId'] ?? null)->first();
        if (!$booking) {
            return response()->json([
                'resultCode' => 1,
                'message' => 'Order not found',
            ]);
        }

        if ((int) ($payload['amount'] ?? 0) !== (int) $booking->total_price) {
            return response()->json([
                'resultCode' => 4,
                'message' => 'Invalid amount',
            ]);
        }

        if ($booking->status !== 'pending') {
            return response()->json([
                'resultCode' => 2,
                'message' => 'Order already processed',
            ]);
        }

        $this->completeMomoPayment($booking, $payload, false);

        return response()->json([
            'resultCode' => 0,
            'message' => 'Confirm success',
        ]);
    }

    public function momoUatCreate(Request $request)
    {
        $responseData = $this->createMomoUatPaymentResponse($request->all());
        $status = match ($responseData['resultCode'] ?? null) {
            0 => 200,
            2 => 422,
            default => 400,
        };

        return response()->json($responseData, $status);
    }

    public function momoUatPay(Request $request)
    {
        $requestId = $request->query('requestId');
        $payment = Session::get('momo_uat.' . $requestId);

        abort_if(!$payment, 404);

        return view('bookings.momo-uat', compact('payment'));
    }

    public function momoUatComplete(Request $request)
    {
        $request->validate([
            'requestId' => 'required|string',
            'result' => 'required|in:success,failed',
        ]);

        $payment = Session::get('momo_uat.' . $request->requestId);
        abort_if(!$payment, 404);

        $payload = $this->buildMomoCallbackPayload(
            $payment,
            $request->result === 'success' ? 0 : 1006,
            $request->result === 'success' ? 'Successful.' : 'Transaction failed by UAT simulator.'
        );

        if ($booking = Booking::where('booking_code', $payload['orderId'])->first()) {
            $this->completeMomoPayment($booking, $payload, false);
        }

        Session::forget('momo_uat.' . $request->requestId);

        return redirect()->away($payment['redirectUrl'] . '?' . http_build_query($payload, '', '&', PHP_QUERY_RFC3986));
    }

    /* ===================== SHOW ===================== */
    public function show(Booking $booking)
    {
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort_if($booking->user_id !== Auth::id(), 403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $booking->load(['showtime.movie', 'showtime.room', 'user']);
        $showtimes = Showtime::with(['movie', 'room'])
            ->where('start_time', '>=', now()->subDay())
            ->orderBy('start_time')
            ->get();

        return view('bookings.edit', compact('booking', 'showtimes'));
    }

    public function update(Request $request, Booking $booking)
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $data = $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|string|max:255',
            'total_price' => 'required|integer|min:0',
            'payment_method' => 'required|in:cash,transfer,online',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $selectedSeats = $this->normalizeSeats($data['seats']);

        if (empty($selectedSeats)) {
            return back()
                ->withInput()
                ->withErrors(['seats' => 'Vui lòng nhập ít nhất một ghế.']);
        }

        $result = DB::transaction(function () use ($booking, $data, $selectedSeats) {
            $showtime = Showtime::with('room')
                ->whereKey($data['showtime_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $invalidSeats = $this->invalidSeats($showtime, $selectedSeats);
            if (!empty($invalidSeats)) {
                return ['invalidSeats' => $invalidSeats];
            }

            $occupiedSeats = Booking::where('showtime_id', $showtime->id)
                ->where('id', '!=', $booking->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate()
                ->pluck('seats')
                ->flatMap(fn ($seats) => explode(',', $seats))
                ->map(fn ($seat) => strtoupper(trim($seat)))
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            $duplicatedSeats = array_values(array_intersect($selectedSeats, $occupiedSeats));
            if (!empty($duplicatedSeats) && in_array($data['status'], ['pending', 'confirmed'], true)) {
                return ['duplicatedSeats' => $duplicatedSeats];
            }

            $booking->update([
                'showtime_id' => $showtime->id,
                'room_code' => $showtime->room->name,
                'seats' => implode(',', $selectedSeats),
                'total_price' => $data['total_price'],
                'payment_method' => $data['payment_method'],
                'status' => $data['status'],
                'confirmed_at' => $data['status'] === 'confirmed'
                    ? ($booking->confirmed_at ?? now())
                    : null,
                'confirmed_by' => $data['status'] === 'confirmed'
                    ? ($booking->confirmed_by ?? Auth::id())
                    : null,
            ]);

            return ['booking' => $booking];
        });

        if (!empty($result['invalidSeats'])) {
            return back()
                ->withInput()
                ->withErrors(['seats' => 'Ghế không tồn tại trong phòng: ' . implode(', ', $result['invalidSeats'])]);
        }

        if (!empty($result['duplicatedSeats'])) {
            return back()
                ->withInput()
                ->withErrors(['seats' => 'Ghế đã được đặt: ' . implode(', ', $result['duplicatedSeats'])]);
        }

        $route = Auth::user()->role === 'admin' ? 'admin.bookings.show' : 'staff.bookings.show';

        return redirect()
            ->route($route, $booking)
            ->with('success', 'Cập nhật booking thành công.');
    }

    public function destroy(Booking $booking)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Đã xóa booking.');
    }

    /* ===================== QR CODE (USER) ===================== */
    public function qr(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->status !== 'confirmed', 403);

        $qr = QrCode::size(250)->generate(
            route('staff.bookings.scan', $booking->booking_code)
        );

        return view('bookings.qr', compact('booking', 'qr'));
    }

    /* ===================== EXPORT PDF ===================== */
    public function exportPdf(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['showtime.movie', 'showtime.room']);

        $canShowQr = $booking->status === 'confirmed'
            && !$booking->checked_in_at
            && now()->lt($booking->showtime->start_time);

        $qrDataUri = $canShowQr
            ? 'data:image/svg+xml;base64,' . base64_encode(
                QrCode::format('svg')
                    ->size(180)
                    ->margin(2)
                    ->generate(route('staff.bookings.scan', $booking->booking_code))
            )
            : null;

        $pdf = Pdf::loadView('bookings.pdf', compact('booking', 'qrDataUri', 'canShowQr'));

        return $pdf->download("ticket_{$booking->booking_code}.pdf");
    }

    /* ===================== STAFF CONFIRM (THANH TOÁN) ===================== */
    public function confirm(Booking $booking)
    {
        abort_unless(Auth::user()->role === 'staff', 403);
        abort_if($booking->status !== 'pending', 409);

        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id(),
        ]);

        return back()->with('success', '✅ Vé đã được xác nhận');
    }

/* ===================== STAFF SCAN QR (CHECK-IN) ===================== */
public function scanQr(string $bookingCode)
{
    abort_unless(Auth::user()->role === 'staff', 403);

    $booking = Booking::where('booking_code', $bookingCode)
        ->with(['showtime.movie', 'user'])
        ->firstOrFail();

    /* ❌ SUẤT CHIẾU ĐÃ BẮT ĐẦU */
    if (now()->gte($booking->showtime->start_time)) {
        return view('bookings.staff.scan-result', [
            'status'  => 'closed',
            'message' => '⏰ Suất chiếu đã bắt đầu – QR check-in đã đóng',
        ]);
    }

    /* ❌ ĐÃ CHECK-IN TRƯỚC ĐÓ */
    if ($booking->checked_in_at) {
        return view('bookings.staff.scan-result', [
            'status'  => 'used',
            'message' => '⚠️ Vé này đã được check-in trước đó',
        ]);
    }

    /* ✅ CHECK-IN HỢP LỆ */
    if ($booking->status !== 'confirmed') {
        return view('bookings.staff.scan-result', [
            'status'  => 'pending',
            'message' => 'Ve chua duoc xac nhan thanh toan',
        ]);
    }

    $booking->update([
        'checked_in_at' => now(),
    ]);

    return view('bookings.staff.scan-result', [
        'status'  => 'success',
        'booking' => $booking,
    ]);
}

    private function normalizeSeats(string $rawSeats): array
    {
        return collect(explode(',', $rawSeats))
            ->map(fn ($seat) => strtoupper(trim($seat)))
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    private function invalidSeats(Showtime $showtime, array $selectedSeats): array
    {
        $validSeats = collect($showtime->room->generateSeats());

        return collect($selectedSeats)
            ->reject(fn ($seat) => $validSeats->contains($seat))
            ->values()
            ->toArray();
    }

    private function occupiedSeatsForShowtime(int $showtimeId): array
    {
        return Booking::where('showtime_id', $showtimeId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->flatMap(fn ($seats) => explode(',', $seats))
            ->map(fn ($seat) => trim($seat))
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    private function isMomoConfigured(): bool
    {
        return filled(Config::get('services.momo.partner_code'))
            && filled(Config::get('services.momo.access_key'))
            && filled(Config::get('services.momo.secret_key'));
    }

    private function createMomoPaymentUrl(Booking $booking): string
    {
        $requestId = $booking->booking_code . '-' . now()->format('YmdHis');
        $amount = (string) ((int) $booking->total_price);
        $extraData = base64_encode(json_encode([
            'booking_code' => $booking->booking_code,
        ]));

        $payload = [
            'partnerCode' => Config::get('services.momo.partner_code'),
            'accessKey' => Config::get('services.momo.access_key'),
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $booking->booking_code,
            'orderInfo' => 'Thanh toan ve ' . $booking->booking_code,
            'redirectUrl' => route('bookings.payment.momo.return'),
            'ipnUrl' => route('payments.momo.ipn'),
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'lang' => Config::get('services.momo.lang', 'vi'),
        ];

        $payload['signature'] = $this->makeMomoSignature([
            'accessKey' => $payload['accessKey'],
            'amount' => $payload['amount'],
            'extraData' => $payload['extraData'],
            'ipnUrl' => $payload['ipnUrl'],
            'orderId' => $payload['orderId'],
            'orderInfo' => $payload['orderInfo'],
            'partnerCode' => $payload['partnerCode'],
            'redirectUrl' => $payload['redirectUrl'],
            'requestId' => $payload['requestId'],
            'requestType' => $payload['requestType'],
        ]);

        $endpoint = Config::get('services.momo.endpoint');

        if ($this->isInternalMomoUatEndpoint($endpoint)) {
            $responseData = $this->createMomoUatPaymentResponse($payload);

            if (($responseData['resultCode'] ?? null) !== 0 || !filled($responseData['payUrl'] ?? null)) {
                abort(502, $responseData['message'] ?? 'Khong tao duoc lien ket thanh toan MoMo.');
            }

            return $responseData['payUrl'];
        }

        $response = Http::asJson()
            ->timeout(15)
            ->post($endpoint, $payload);

        if (!$response->successful() || !filled($response->json('payUrl'))) {
            abort(502, 'Khong tao duoc lien ket thanh toan MoMo.');
        }

        return $response->json('payUrl');
    }

    private function isInternalMomoUatEndpoint(?string $endpoint): bool
    {
        if (!filled($endpoint)) {
            return true;
        }

        return parse_url($endpoint, PHP_URL_PATH) === '/momo-uat/create';
    }

    private function createMomoUatPaymentResponse(array $payload): array
    {
        if (!$this->hasValidMomoCreateSignature($payload)) {
            return [
                'partnerCode' => $payload['partnerCode'] ?? null,
                'orderId' => $payload['orderId'] ?? null,
                'requestId' => $payload['requestId'] ?? null,
                'resultCode' => 97,
                'message' => 'Invalid signature',
            ];
        }

        $required = ['partnerCode', 'requestId', 'amount', 'orderId', 'orderInfo', 'redirectUrl', 'ipnUrl', 'requestType'];
        foreach ($required as $key) {
            if (!filled($payload[$key] ?? null)) {
                return [
                    'partnerCode' => $payload['partnerCode'] ?? null,
                    'orderId' => $payload['orderId'] ?? null,
                    'requestId' => $payload['requestId'] ?? null,
                    'resultCode' => 2,
                    'message' => 'Missing ' . $key,
                ];
            }
        }

        Session::put('momo_uat.' . $payload['requestId'], $payload);

        return [
            'partnerCode' => $payload['partnerCode'],
            'orderId' => $payload['orderId'],
            'requestId' => $payload['requestId'],
            'amount' => (int) $payload['amount'],
            'responseTime' => now()->valueOf(),
            'message' => 'Successful.',
            'resultCode' => 0,
            'payUrl' => route('momo.uat.pay', ['requestId' => $payload['requestId']]),
        ];
    }

    private function hasValidMomoSignature(array $payload): bool
    {
        $signature = $payload['signature'] ?? null;

        if (!is_string($signature)) {
            return false;
        }

        $keys = [
            'accessKey',
            'amount',
            'extraData',
            'message',
            'orderId',
            'orderInfo',
            'orderType',
            'partnerCode',
            'payType',
            'requestId',
            'responseTime',
            'resultCode',
            'transId',
        ];

        $data = ['accessKey' => Config::get('services.momo.access_key')];
        foreach ($keys as $key) {
            if ($key !== 'accessKey' && array_key_exists($key, $payload)) {
                $data[$key] = (string) $payload[$key];
            }
        }

        return hash_equals($this->makeMomoSignature($data), $signature);
    }

    private function hasValidMomoCreateSignature(array $payload): bool
    {
        $signature = $payload['signature'] ?? null;

        if (!is_string($signature)) {
            return false;
        }

        $data = [];
        foreach (['accessKey', 'amount', 'extraData', 'ipnUrl', 'orderId', 'orderInfo', 'partnerCode', 'redirectUrl', 'requestId', 'requestType'] as $key) {
            if (array_key_exists($key, $payload)) {
                $data[$key] = (string) $payload[$key];
            }
        }

        return hash_equals($this->makeMomoSignature($data), $signature);
    }

    private function makeMomoSignature(array $data): string
    {
        $rawSignature = collect($data)
            ->map(fn ($value, $key) => $key . '=' . $value)
            ->implode('&');

        return hash_hmac('sha256', $rawSignature, Config::get('services.momo.secret_key'));
    }

    private function buildMomoCallbackPayload(array $payment, int $resultCode, string $message): array
    {
        $payload = [
            'partnerCode' => $payment['partnerCode'],
            'orderId' => $payment['orderId'],
            'requestId' => $payment['requestId'],
            'amount' => (string) $payment['amount'],
            'orderInfo' => $payment['orderInfo'],
            'orderType' => 'momo_wallet',
            'transId' => (string) random_int(1000000000, 9999999999),
            'resultCode' => (string) $resultCode,
            'message' => $message,
            'payType' => 'qr',
            'responseTime' => (string) now()->valueOf(),
            'extraData' => $payment['extraData'] ?? '',
        ];

        $payload['signature'] = $this->makeMomoSignature([
            'accessKey' => Config::get('services.momo.access_key'),
            'amount' => $payload['amount'],
            'extraData' => $payload['extraData'],
            'message' => $payload['message'],
            'orderId' => $payload['orderId'],
            'orderInfo' => $payload['orderInfo'],
            'orderType' => $payload['orderType'],
            'partnerCode' => $payload['partnerCode'],
            'payType' => $payload['payType'],
            'requestId' => $payload['requestId'],
            'responseTime' => $payload['responseTime'],
            'resultCode' => $payload['resultCode'],
            'transId' => $payload['transId'],
        ]);

        return $payload;
    }

    private function completeMomoPayment(Booking $booking, array $payload, bool $redirect)
    {
        if ((int) ($payload['amount'] ?? 0) !== (int) $booking->total_price) {
            return $redirect
                ? redirect()->route('bookings.history')->withErrors(['payment' => 'So tien thanh toan khong khop voi ve.'])
                : null;
        }

        $isSuccess = (int) ($payload['resultCode'] ?? -1) === 0;

        if (!$isSuccess) {
            if ($booking->status === 'pending') {
                $booking->update(['status' => 'cancelled']);
            }

            return $redirect
                ? redirect()->route('bookings.history')->withErrors(['payment' => 'Thanh toan MoMo khong thanh cong. Ve da duoc huy de nha ghe.'])
                : null;
        }

        if ($booking->status === 'pending') {
            $booking->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
        }

        return $redirect
            ? redirect()->route('bookings.show', $booking)->with('success', 'Thanh toan MoMo thanh cong. Ve da duoc xac nhan.')
            : null;
    }
}
