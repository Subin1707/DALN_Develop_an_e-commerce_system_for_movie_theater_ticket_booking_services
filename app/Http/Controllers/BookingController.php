<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        abort_if($showtime->start_time < now(), 403);

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

        abort_if($showtime->start_time < now(), 403);

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

    /* ===================== STORE ===================== */
    public function store(Request $request)
    {
        abort_if(in_array(Auth::user()->role, ['admin', 'staff']), 403);

        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,id',
            'seats'          => 'required|string',
            'payment_method' => 'required|in:cash,transfer,online',
        ]);

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

            $isOnlinePayment = $request->payment_method === 'online';

            return Booking::create([
                'user_id'        => Auth::id(),
                'showtime_id'    => $showtime->id,
                'room_code'      => $showtime->room->name ?? null,
                'seats'          => implode(',', $selectedSeats),
                'total_price'    => count($selectedSeats) * $showtime->price,
                'payment_method' => $request->payment_method,
                'status'         => $isOnlinePayment ? 'confirmed' : 'pending',
                'confirmed_at'   => $isOnlinePayment ? now() : null,
            ]);
        });

        if (is_array($booking) && !empty($booking['duplicatedSeats'])) {
            return redirect()
                ->route('bookings.create', $showtime)
                ->with('error', 'Ghe da duoc dat: ' . implode(', ', $booking['duplicatedSeats']) . '. Vui long chon ghe khac.');
        }

        return redirect()
            ->route('bookings.history')
            ->with('success', '🎟️ Đặt vé thành công!');
    }

    /* ===================== SHOW ===================== */
    public function show(Booking $booking)
    {
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort_if($booking->user_id !== Auth::id(), 403);
        }

        return view('bookings.show', compact('booking'));
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

        $qr = $canShowQr
            ? QrCode::size(150)->generate(route('staff.bookings.scan', $booking->booking_code))
            : null;

        $pdf = Pdf::loadView('bookings.pdf', compact('booking', 'qr', 'canShowQr'));

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
}
