@extends('layouts.app')

@section('title', 'Sửa nhân viên')

@section('content')
<div class="staff-form-page">
    <section class="staff-form-hero">
        <div class="staff-form-icon">
            <i class="fa fa-pencil"></i>
        </div>
        <div>
            <span class="staff-form-kicker">Quản lý nhân viên</span>
            <h1>Sửa thông tin nhân viên</h1>
            <p>Cập nhật tên, email hoặc đặt lại mật khẩu cho tài khoản nhân viên.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.staffs.update', $staff->id) }}" class="staff-form-panel">
        @method('PUT')
        @include('staffs._form', ['staff' => $staff])
    </form>
</div>
@endsection

@include('staffs._form_styles')
