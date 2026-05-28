@extends('layouts.app')

@section('content')
<div class="room-form-page">
    <section class="room-form-hero">
        <div class="room-form-icon">
            <i class="fa fa-plus"></i>
        </div>
        <div>
            <span class="room-form-kicker">Quản lý phòng chiếu</span>
            <h1>Thêm phòng chiếu mới</h1>
            <p>Tạo phòng mới, gán rạp chiếu và thiết lập sức chứa.</p>
        </div>
    </section>

    <form action="{{ route('admin.rooms.store') }}" method="POST" class="room-form-panel">
        @csrf
        @include('rooms._form', ['theaters' => $theaters])
    </form>
</div>
@endsection

@include('rooms._form_styles')
