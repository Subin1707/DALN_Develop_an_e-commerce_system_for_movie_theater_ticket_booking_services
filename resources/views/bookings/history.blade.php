@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <h4 class="mb-0">
        <i class="fa fa-history col_red me-1"></i>
        Lịch sử <span class="col_red">Đặt vé</span>
    </h4>

    <a href="{{ route('bookings.choose') }}" class="btn bg_red text-white">
        <i class="fa fa-plus me-1"></i> Đặt vé mới
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($bookings->isEmpty())
    <div class="alert alert-info">Bạn chưa đặt vé nào.</div>
@else
    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th>Mã vé</th>
                        <th>Phim</th>
                        <th>Phòng</th>
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
                        @continue($booking->user_id !== auth()->id())

                        <tr>
                            <td>
                                <span class="table-code">{{ $booking->booking_code ?? '#' . $booking->id }}</span>
                            </td>
                            <td>
                                <div class="table-title">{{ $booking->showtime->movie->title ?? 'N/A' }}</div>
                            </td>
                            <td>{{ $booking->showtime->room->code ?? $booking->showtime->room->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') }}</td>
                            <td>{{ $booking->seats }}</td>
                            <td class="table-money">{{ number_format($booking->total_price) }} đ</td>
                            <td>
                                @if($booking->payment_method === 'cash')
                                    <span class="cinema-badge warning"><i class="fa fa-money"></i> Tiền mặt</span>
                                @elseif($booking->payment_method === 'transfer')
                                    <span class="cinema-badge info"><i class="fa fa-bank"></i> Chuyển khoản</span>
                                @elseif($booking->payment_method === 'online')
                                    <span class="cinema-badge success"><i class="fa fa-credit-card"></i> Online</span>
                                @else
                                    <span class="cinema-badge neutral">N/A</span>
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
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-info btn-sm cinema-action-btn">
                                    <i class="fa fa-eye"></i> Xem
                                </a>
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
