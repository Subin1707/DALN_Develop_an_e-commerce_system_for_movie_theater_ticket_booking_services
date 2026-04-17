@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎬 Thông tin rạp: {{ $theater->name }}</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>Địa chỉ:</strong> {{ $theater->address }}</li>
        <li class="list-group-item"><strong>Tổng số phòng:</strong> {{ $theater->total_rooms }}</li>
        <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $theater->created_at->format('d/m/Y') }}</li>
    </ul>
    <a href="{{ route('theaters.index') }}" class="btn btn-secondary mt-3">⬅️ Quay lại</a>
</div>
@endsection
