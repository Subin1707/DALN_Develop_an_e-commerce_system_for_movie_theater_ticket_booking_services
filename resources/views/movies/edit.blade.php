@extends('layouts.app')

@section('content')
<div class="movie-form-page">
    <section class="movie-form-hero">
        <div class="movie-form-icon">
            <i class="fa fa-pencil"></i>
        </div>
        <div>
            <span class="movie-form-kicker">Quản lý phim</span>
            <h1>Sửa phim</h1>
            <p>Cập nhật thông tin phim, poster và trạng thái hiển thị.</p>
        </div>
    </section>

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data" class="movie-form-panel">
        @csrf
        @method('PUT')

        @include('movies._form')

        <div class="movie-form-actions">
            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary movie-form-btn">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
            <button type="submit" class="btn btn-primary movie-form-btn">
                <i class="fa fa-save"></i> Cập nhật phim
            </button>
        </div>
    </form>
</div>
@endsection

@include('movies._form_styles')
