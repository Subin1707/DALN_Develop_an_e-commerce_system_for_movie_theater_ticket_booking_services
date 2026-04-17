@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎬 Thêm suất chiếu mới</h1>

    @if(Auth::check() && Auth::user()->role === 'admin')
        <form action="{{ route('admin.showtimes.store') }}" method="POST">
            @csrf
            @include('showtimes._form')
        </form>
    @else
        <div class="alert alert-danger">
            Bạn không có quyền truy cập trang này.
        </div>
    @endif
</div>
@endsection
