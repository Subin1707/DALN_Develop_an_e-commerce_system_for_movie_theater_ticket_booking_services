@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-6">
        <h4>
            <i class="fa fa-ticket col_red me-1"></i>
            Quản lý <span class="col_red">Booking</span>
        </h4>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($bookings->isEmpty())
    <div class="alert alert-info">Chưa có booking nào.</div>
@else
<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Phim</th>
            <th>Ngày giờ</th>
            <th>Ghế</th>
            <th>Tổng tiền</th>
            <th>Thanh toán</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->user->name ?? 'N/A' }}</td>
            <td>{{ $booking->showtime->movie->title ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</td>
            <td>{{ $booking->seats }}</td>
            <td>{{ number_format($booking->total_price) }} ₫</td>
            <td>
                @if($booking->payment_method === 'cash')
                    💵 Tiền mặt
                @elseif($booking->payment_method === 'online')
                    Online
                @else
                    🏦 Chuyển khoản
                @endif
            </td>
            <td>
                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm">Xem</a>
                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-sm">Sửa</a>
                <form action="{{ route('admin.bookings.destroy', $booking) }}"
                      method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Xóa booking này?')">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $bookings->links() }}
@endif

@endsection
