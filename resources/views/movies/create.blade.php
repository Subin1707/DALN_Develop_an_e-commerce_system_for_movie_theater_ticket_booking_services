@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">➕ Thêm phim mới</h1>

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('movies._form')
        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary ms-2">⬅️ Quay lại</a>
    </form>
</div>
@endsection
