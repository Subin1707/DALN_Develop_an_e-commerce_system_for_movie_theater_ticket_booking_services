@extends('layouts.app')

@section('title', 'Thêm nhân viên')

@section('content')
<div class="staff-form-page">
    <section class="staff-form-hero">
        <div class="staff-form-icon">
            <i class="fa fa-id-badge"></i>
        </div>
        <div>
            <span class="staff-form-kicker">Quản lý nhân viên</span>
            <h1>Thêm nhân viên mới</h1>
            <p>Tạo tài khoản nhân viên để hỗ trợ xác nhận vé, check-in và chăm sóc khách hàng.</p>
        </div>
    </section>

    <form action="{{ route('admin.staffs.store') }}" method="POST" class="staff-form-panel">
        @include('staffs._form')
    </form>
</div>
@endsection

@include('staffs._form_styles')
