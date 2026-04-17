@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Sửa phim</h1>

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('movies._form')
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary ms-2">⬅️ Quay lại</a>
    </form>
</div>
@endsection
