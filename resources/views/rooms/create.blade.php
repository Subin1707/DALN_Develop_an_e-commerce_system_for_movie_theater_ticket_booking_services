@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">➕ Thêm phòng chiếu mới</h1>

    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        @include('rooms._form', ['theaters' => $theaters])
    </form>

    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mt-3">⬅️ Quay lại</a>
</div>
@endsection
