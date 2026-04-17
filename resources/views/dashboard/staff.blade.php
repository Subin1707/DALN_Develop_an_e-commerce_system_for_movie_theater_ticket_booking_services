@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')

<div class="container py-5 text-white">

    <div class="text-center mb-5">
        <h1 class="text-3xl fw-bold text-info">👨‍💼 Nhân viên</h1>
        <p>Xin chào <strong>{{ $user->name }}</strong></p>
    </div>

    <div class="row g-4">

        <div class="col-md-4 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-calendar fa-2x text-info mb-2"></i>
                <h3>{{ $upcomingShowtimes }}</h3>
                <p>Suất chiếu sắp tới</p>
            </div>
        </div>

        <div class="col-md-4 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-ticket fa-2x text-info mb-2"></i>
                <h3>{{ $todayBookings }}</h3>
                <p>Booking hôm nay</p>
            </div>
        </div>

        <div class="col-md-4 col-6">
            <div class="p-4 bg-white bg-opacity-10 rounded text-center">
                <i class="fa fa-list fa-2x text-info mb-2"></i>
                <h3>{{ $totalTickets }}</h3>
                <p>Tổng vé</p>
            </div>
        </div>

    </div>

    <hr class="my-5">

    <div class="text-center">
        <a href="{{ route('staff.bookings.index') }}" class="btn btn-outline-info">
            🎟️ Kiểm tra booking
        </a>
    </div>

</div>

@endsection
