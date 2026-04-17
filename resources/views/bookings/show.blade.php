@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4 class="mb-0">
            <i class="fa fa-ticket col_red me-1"></i>
            Chi tiết <span class="col_red">Vé {{ $booking->booking_code }}</span>
        </h4>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        {{-- ================= INFO ================= --}}
        <ul class="list-group list-group-flush mb-4">

            <li class="list-group-item">
                <strong>👤 Khách hàng:</strong>
                {{ $booking->user->name ?? 'N/A' }}
            </li>

            <li class="list-group-item">
                <strong>🎬 Phim:</strong>
                {{ $booking->showtime->movie->title ?? 'N/A' }}
            </li>

            <li class="list-group-item">
                <strong>🕒 Suất chiếu:</strong>
                {{ $booking->showtime->start_time->format('d/m/Y H:i') }}
            </li>

            <li class="list-group-item">
                <strong>🏢 Phòng:</strong>
                {{ $booking->showtime->room->name ?? 'N/A' }}
            </li>

            <li class="list-group-item">
                <strong>💺 Ghế:</strong>
                {{ $booking->seats }}
            </li>

            <li class="list-group-item">
                <strong>💰 Tổng tiền:</strong>
                {{ number_format($booking->total_price) }} ₫
            </li>

            <li class="list-group-item">
                <strong>💳 Thanh toán:</strong>
                @if($booking->payment_method === 'cash')
                    <span class="badge bg-warning text-dark">💵 Tiền mặt</span>
                @else
                    <span class="badge bg-info">🏦 Chuyển khoản</span>
                @endif
            </li>

            <li class="list-group-item">
                <strong>📌 Trạng thái:</strong>

                @if($booking->status === 'pending')
                    <span class="badge bg-warning">⏳ Chờ xác nhận</span>
                @elseif($booking->status === 'confirmed')
                    <span class="badge bg-success">✅ Đã đặt chỗ</span>
                @endif
            </li>

        </ul>

        {{-- ================= QR CODE CHECK-IN ================= --}}
        @if(now()->lt($booking->showtime->start_time))
            <div class="text-center mb-4">
                <h5 class="mb-3">🔲 Mã QR Check-in</h5>

                {!! QrCode::size(220)->generate(
                    route('staff.bookings.scan', $booking->booking_code)
                ) !!}

                <p class="text-muted mt-2">
                    Xuất trình mã QR này cho nhân viên trước giờ chiếu
                </p>
            </div>
        @else
            <div class="alert alert-secondary text-center">
                ⏰ Suất chiếu đã bắt đầu – QR check-in đã đóng
            </div>
        @endif

        {{-- ================= ACTIONS ================= --}}
        <div class="d-flex flex-wrap gap-2">

            {{-- USER --}}
            @if(Auth::id() === $booking->user_id)
                <a href="{{ route('bookings.pdf', $booking->id) }}"
                class="btn btn-danger">
                    📄 Xuất vé PDF
</a>
            @endif

            {{-- STAFF --}}
            @if(Auth::user()->role === 'staff' && $booking->status === 'pending')
                <form action="{{ route('staff.bookings.confirm', $booking->id) }}"
                      method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success">
                        ✅ Xác nhận thanh toán
                    </button>
                </form>
            @endif

            {{-- ADMIN --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                   class="btn btn-warning">
                    ✏️ Chỉnh sửa
                </a>
            @endif

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                ⬅ Quay lại
            </a>

        </div>

    </div>
</div>

@endsection
