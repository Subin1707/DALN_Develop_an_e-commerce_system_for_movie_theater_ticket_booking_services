@extends('layouts.app')

@section('title', 'Chi tiết nhân viên')

@section('content')
<div class="container mx-auto py-8 text-gray-200">
    <h1 class="text-xl font-bold mb-4">👤 {{ $staff->name }}</h1>

    <p>Email: {{ $staff->email }}</p>
    <p>Vai trò: Nhân viên</p>

    <a href="{{ route('admin.staffs.index') }}" class="text-blue-400">
        ← Quay lại
    </a>
</div>
@endsection
