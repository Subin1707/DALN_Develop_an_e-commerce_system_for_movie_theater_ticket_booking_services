@extends('layouts.app')

@section('content')

<div class="container text-center mt-4">

    <h3 class="mb-3">🎫 Vé xem phim</h3>

    <p class="mb-1">
        <strong>Mã vé:</strong>
        <span class="text-danger fw-bold">
            {{ $booking->booking_code }}
        </span>
    </p>

    {{-- ================= QR CODE ================= --}}
    @if($booking->status === 'confirmed' && !$booking->confirmed_at)

        <div class="my-4">
            {!! QrCode::size(240)->generate(
                route('staff.bookings.scan', $booking->booking_code)
            ) !!}
        </div>

        <p class="text-muted">
            Vui lòng xuất trình mã QR này cho nhân viên khi vào rạp
        </p>

    @else
        <div class="alert alert-secondary mt-4">
            🎬 Vé đã được sử dụng hoặc chưa được xác nhận
        </div>
    @endif

    <a href="{{ route('bookings.show', $booking->id) }}"
       class="btn btn-outline-secondary mt-3">
        ⬅ Quay lại chi tiết vé
    </a>

</div>

@endsection
