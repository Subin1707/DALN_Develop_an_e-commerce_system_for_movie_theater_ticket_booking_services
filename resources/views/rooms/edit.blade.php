@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Sửa phòng chiếu</h1>

    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        @include('rooms._form', ['room' => $room, 'theaters' => $theaters])
    </form>

    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mt-3">⬅️ Quay lại</a>
</div>
@endsection
