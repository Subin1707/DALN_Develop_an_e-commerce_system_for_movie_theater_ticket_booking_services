@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ====== ALERT TRẠNG THÁI ====== --}}
    @if($status === 'success')
        <div class="alert alert-success mb-4">
            <h4 class="mb-0">✅ Check-in thành công</h4>
            <small class="text-muted">
                Vé đã được ghi nhận vào rạp
            </small>
        </div>

    @elseif($status === 'used')
        <div class="alert alert-warning mb-4">
            <h4 class="mb-0">⚠️ Vé đã được sử dụng</h4>
            <small class="text-muted">
                Vé này đã check-in trước đó
            </small>
        </div>

    @elseif($status === 'closed')
        <div class="alert alert-danger mb-4">
            <h4 class="mb-0">⏰ QR đã đóng</h4>
            <small class="text-muted">
                Suất chiếu đã bắt đầu
            </small>
        </div>
    @endif


    {{-- ====== THÔNG TIN VÉ (CHỈ HIỆN KHI CÓ BOOKING) ====== --}}
    @isset($booking)
        <ul class="list-group mb-4">

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
                {{ optional($booking->showtime->start_time)->format('d/m/Y H:i') }}
            </li>

            <li class="list-group-item">
                <strong>🏢 Phòng:</strong>
                {{ $booking->room_code ?? ($booking->showtime->room->name ?? 'N/A') }}
            </li>

            <li class="list-group-item">
                <strong>💺 Ghế:</strong>
                {{ $booking->seats }}
            </li>

            <li class="list-group-item">
                <strong>📌 Trạng thái:</strong>

                @if($status === 'success')
                    <span class="badge bg-success">🎬 ĐÃ VÀO RẠP</span>
                @elseif($status === 'used')
                    <span class="badge bg-warning">⚠️ ĐÃ DÙNG</span>
                @elseif($status === 'closed')
                    <span class="badge bg-secondary">⏰ ĐÃ ĐÓNG</span>
                @endif
            </li>

            @if($booking->checked_in_at)
                <li class="list-group-item">
                    <strong>⏱ Thời gian check-in:</strong>
                    {{ $booking->checked_in_at->format('d/m/Y H:i:s') }}
                </li>
            @endif

        </ul>
    @endisset


    {{-- ====== ACTION ====== --}}
    <div class="d-flex gap-2">
        <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">
            ⬅ Về Dashboard
        </a>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            🔁 Scan vé khác
        </a>
    </div>

</div>
@endsection
