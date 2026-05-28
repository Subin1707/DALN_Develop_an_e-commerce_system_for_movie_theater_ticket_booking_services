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
    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th>Mã vé</th>
                        <th>Khách hàng</th>
                        <th>Phim</th>
                        <th>Ngày giờ</th>
                        <th>Ghế</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td><span class="table-code">{{ $booking->booking_code ?? '#' . $booking->id }}</span></td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td><div class="table-title">{{ $booking->showtime->movie->title ?? 'N/A' }}</div></td>
                            <td>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</td>
                            <td>{{ $booking->seats }}</td>
                            <td class="table-money">{{ number_format($booking->total_price) }} đ</td>
                            <td>
                                @if($booking->payment_method === 'cash')
                                    <span class="cinema-badge warning"><i class="fa fa-money"></i> Tiền mặt</span>
                                @elseif($booking->payment_method === 'online')
                                    <span class="cinema-badge success"><i class="fa fa-credit-card"></i> Online</span>
                                @else
                                    <span class="cinema-badge info"><i class="fa fa-bank"></i> Chuyển khoản</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status === 'confirmed')
                                    <span class="cinema-badge success">Đã xác nhận</span>
                                @elseif($booking->status === 'pending')
                                    <span class="cinema-badge warning">Chờ xử lý</span>
                                @else
                                    <span class="cinema-badge danger">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="cinema-actions justify-content-end">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm cinema-action-btn">
                                        <i class="fa fa-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-sm cinema-action-btn">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm cinema-action-btn" onclick="return confirm('Xóa booking này?')">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
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
