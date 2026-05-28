@extends('layouts.app')

@section('content')
<div class="theater-form-page">
    <section class="theater-form-hero">
        <div class="theater-form-icon">
            <i class="fa fa-pencil"></i>
        </div>
        <div>
            <span class="theater-form-kicker">Quản lý rạp chiếu</span>
            <h1>Sửa thông tin rạp</h1>
            <p>Cập nhật tên rạp, địa chỉ và số lượng phòng chiếu.</p>
        </div>
    </section>

    <form action="{{ route('admin.theaters.update', $theater) }}" method="POST" class="theater-form-panel">
        @method('PUT')
        @include('theaters._form', ['theater' => $theater])
    </form>
</div>
@endsection

@include('theaters._form_styles')
