@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container py-5 text-white">

    <div class="text-center mb-5">
        <h1 class="text-3xl fw-bold text-warning">🛠️ Quản trị hệ thống</h1>
        <p>Xin chào <strong>{{ $user->name }}</strong> (Admin)</p>
    </div>

    <div class="row g-4">

        <div class="col-md-3 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-users fa-2x text-danger mb-2"></i>
                <h3>{{ $userCount }}</h3>
                <p>Người dùng</p>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-film fa-2x text-danger mb-2"></i>
                <h3>{{ $movieCount }}</h3>
                <p>Phim</p>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-ticket fa-2x text-danger mb-2"></i>
                <h3>{{ $ticketCount }}</h3>
                <p>Vé đã bán</p>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-money fa-2x text-danger mb-2"></i>
                <h3>{{ number_format($revenue) }} ₫</h3>
                <p>Doanh thu</p>
            </div>
        </div>

    </div>

    <hr class="my-5">

    <div class="text-center">
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-warning m-1">🎬 Quản lý phim</a>
        <a href="{{ route('admin.showtimes.index') }}" class="btn btn-outline-warning m-1">⏰ Suất chiếu</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-warning m-1">🎟️ Booking</a>
        <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline-warning m-1">👨‍💼 Nhân viên</a>
    </div>

</div>

@endsection
