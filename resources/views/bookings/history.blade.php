@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4 class="mb-0">
            <i class="fa fa-history col_red me-1"></i>
            Lịch sử <span class="col_red">Đặt vé</span>
        </h4>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($bookings->isEmpty())
    <div class="alert alert-info">
        Bạn chưa đặt vé nào.
    </div>
@else

<div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>🎬 Phim</th>
                <th>🏢 Phòng</th>
                <th>🕒 Ngày giờ</th>
                <th>💺 Ghế</th>
                <th>💰 Tổng tiền</th>
                <th>💳 Thanh toán</th>
                <th>📌 Trạng thái</th>
                <th>⚙️</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bookings as $booking)

                {{-- 🔒 CHỐT AN TOÀN: chỉ hiển thị booking của chính user --}}
                @continue($booking->user_id !== auth()->id())

                <tr>
                    <td>{{ $booking->id }}</td>

                    <td class="text-start">
                        {{ $booking->showtime->movie->title ?? 'N/A' }}
                    </td>

                    {{-- PHÒNG + MÃ --}}
                    <td>
                        <span class="badge bg-secondary">
                            {{ $booking->showtime->room->code 
                                ?? $booking->showtime->room->name 
                                ?? 'N/A' }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($booking->showtime->start_time)
                            ->format('d/m/Y H:i') }}
                    </td>

                    <td>{{ $booking->seats }}</td>

                    <td class="text-danger fw-bold">
                        {{ number_format($booking->total_price) }} ₫
                    </td>

                    <td>
                        @if($booking->payment_method === 'cash')
                            <span class="badge bg-warning text-dark">
                                💵 Tiền mặt
                            </span>
                        @elseif($booking->payment_method === 'transfer')
                            <span class="badge bg-info">
                                🏦 Chuyển khoản
                            </span>
                        @elseif($booking->payment_method === 'online')
                            <span class="badge bg-success">
                                Online
                            </span>
                        @else
                            <span class="badge bg-secondary">N/A</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge bg-{{ 
                            $booking->status === 'confirmed' ? 'success' : 
                            ($booking->status === 'pending' ? 'warning' : 'danger') 
                        }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('bookings.show', $booking->id) }}"
                           class="btn btn-info btn-sm">
                            Xem
                        </a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $bookings->links() }}
</div>

@endif

<a href="{{ route('bookings.choose') }}"
   class="btn btn-primary mt-4">
    🎟️ Đặt vé mới
</a>

@endsection
