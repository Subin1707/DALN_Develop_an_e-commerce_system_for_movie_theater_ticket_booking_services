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
    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th>Mã vé</th>
                        <th>Khách</th>
                        <th>Phim</th>
                        <th>Ngày giờ</th>
                        <th>Ghế</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td><span class="table-code">{{ $booking->booking_code ?? '#' . $booking->id }}</span></td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td><div class="table-title">{{ $booking->showtime->movie->title }}</div></td>
                            <td>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</td>
                            <td>{{ $booking->seats }}</td>
                            <td class="table-money">{{ number_format($booking->total_price) }} đ</td>
                            <td>
                                @if($booking->payment_method === 'cash')
                                    <span class="cinema-badge warning">Tiền mặt</span>
                                @elseif($booking->payment_method === 'online')
                                    <span class="cinema-badge success">Online</span>
                                @else
                                    <span class="cinema-badge info">Chuyển khoản</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status === 'confirmed')
                                    <span class="cinema-badge success">Đã xác nhận</span>
                                @else
                                    <span class="cinema-badge warning">Chờ xử lý</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="cinema-actions justify-content-end">
                                    <a href="{{ route('staff.bookings.show', $booking) }}" class="btn btn-info btn-sm cinema-action-btn">
                                        <i class="fa fa-eye"></i> Xem
                                    </a>

                                    @if($booking->status === 'pending')
                                        <form action="{{ route('staff.bookings.confirm', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm cinema-action-btn">
                                                <i class="fa fa-check"></i> Xác nhận
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $bookings->links() }}
    </div>
@endif
@endsection
