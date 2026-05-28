@extends('layouts.app')

@section('content')
<div class="theater-form-page">
    <section class="theater-form-hero">
        <div class="theater-form-icon">
            <i class="fa fa-plus"></i>
        </div>
        <div>
            <span class="theater-form-kicker">Quản lý rạp chiếu</span>
            <h1>Thêm rạp chiếu mới</h1>
            <p>Tạo rạp mới và thiết lập thông tin cơ bản cho hệ thống.</p>
        </div>
    </section>

    <form action="{{ route('admin.theaters.store') }}" method="POST" class="theater-form-panel">
        @include('theaters._form')
    </form>
</div>
@endsection

@include('theaters._form_styles')
