@extends('layouts.app')

@section('content')
<div class="showtime-form-page">
    <section class="showtime-form-hero">
        <div class="showtime-form-icon">
            <i class="fa fa-pencil"></i>
        </div>
        <div>
            <span class="showtime-form-kicker">Quản lý lịch chiếu</span>
            <h1>Sửa suất chiếu</h1>
            <p>Cập nhật phim, phòng chiếu, thời gian và giá vé cho suất chiếu này.</p>
        </div>
    </section>

    @if(Auth::check() && Auth::user()->role === 'admin')
        <form action="{{ route('admin.showtimes.update', $showtime->id) }}" method="POST" class="showtime-form-panel">
            @method('PUT')

            @include('showtimes._form', [
                'showtime' => $showtime,
                'movies' => $movies,
                'rooms' => $rooms,
                'submitLabel' => 'Cập nhật suất chiếu',
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
