@extends('layouts.app')

@section('content')
<div class="showtime-form-page">
    <section class="showtime-form-hero">
        <div class="showtime-form-icon">
            <i class="fa fa-calendar-plus-o"></i>
        </div>
        <div>
            <span class="showtime-form-kicker">Quản lý lịch chiếu</span>
            <h1>Thêm suất chiếu mới</h1>
            <p>Tạo lịch chiếu mới bằng cách chọn phim, phòng, thời gian và mức giá vé.</p>
        </div>
    </section>

    @if(Auth::check() && Auth::user()->role === 'admin')
        <form action="{{ route('admin.showtimes.store') }}" method="POST" class="showtime-form-panel">
            @include('showtimes._form', [
                'movies' => $movies,
                'rooms' => $rooms,
                'submitLabel' => 'Thêm suất chiếu',
            ])
        </form>
    @else
        <div class="alert alert-danger">
            Bạn không có quyền truy cập trang này.
        </div>
    @endif
</div>
@endsection

@include('showtimes._form_styles')
