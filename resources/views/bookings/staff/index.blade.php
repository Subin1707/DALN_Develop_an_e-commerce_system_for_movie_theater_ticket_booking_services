@extends('layouts.app')

@section('content')

<div class="row trend_1 mb-4">
    <div class="col-md-6">
        <h4>
            <i class="fa fa-ticket col_red me-1"></i>
            Booking <span class="col_red">Chờ xác nhận</span>
        </h4>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($bookings->isEmpty())
    <div class="alert alert-info">Không có booking.</div>
@else
<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách</th>
            <th>Phim</th>
            <th>Ngày giờ</th>
            <th>Ghế</th>
            <th>Tổng tiền</th>
            <th>Thanh toán</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->user->name ?? 'N/A' }}</td>
            <td>{{ $booking->showtime->movie->title }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</td>
            <td>{{ $booking->seats }}</td>
            <td>{{ number_format($booking->total_price) }} ₫</td>
            <td>{{ ucfirst($booking->payment_method) }}</td>
            <td>
                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </td>
            <td>
                <a href="{{ route('staff.bookings.show', $booking) }}"
                   class="btn btn-info btn-sm">Xem</a>

                @if($booking->status === 'pending')
                    <form action="{{ route('staff.bookings.confirm', $booking) }}"
                          method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">
                            Xác nhận
                        </button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $bookings->links() }}
@endif

@endsection
