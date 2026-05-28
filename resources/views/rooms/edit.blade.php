@extends('layouts.app')

@section('content')
<div class="room-form-page">
    <section class="room-form-hero">
        <div class="room-form-icon">
            <i class="fa fa-pencil"></i>
        </div>
        <div>
            <span class="room-form-kicker">Quản lý phòng chiếu</span>
            <h1>Sửa phòng chiếu</h1>
            <p>Cập nhật rạp, tên phòng và sức chứa của phòng chiếu.</p>
        </div>
    </section>

    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="room-form-panel">
        @csrf
        @method('PUT')

        @include('rooms._form', ['room' => $room, 'theaters' => $theaters])
    </form>
</div>
@endsection

@include('rooms._form_styles')
