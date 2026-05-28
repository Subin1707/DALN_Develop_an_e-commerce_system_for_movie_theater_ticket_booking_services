@extends('layouts.app')

@section('content')
<div class="movie-form-page">
    <section class="movie-form-hero">
        <div class="movie-form-icon">
            <i class="fa fa-plus"></i>
        </div>
        <div>
            <span class="movie-form-kicker">Quản lý phim</span>
            <h1>Thêm phim mới</h1>
            <p>Tạo phim mới, tải poster và thiết lập trạng thái hiển thị.</p>
        </div>
    </section>

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" class="movie-form-panel">
        @csrf

        @include('movies._form')

        <div class="movie-form-actions">
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary movie-form-btn">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
            <button type="submit" class="btn btn-primary movie-form-btn">
                <i class="fa fa-plus"></i> Thêm phim
            </button>
        </div>
    </form>
</div>
@endsection

@include('movies._form_styles')
