@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">🎬 Chi tiết suất chiếu: {{ $showtime->movie->title ?? 'N/A' }}</h1>

    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>ID:</strong> {{ $showtime->id }}</li>
        <li class="list-group-item"><strong>Phòng chiếu:</strong> {{ $showtime->room->name ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Thời gian chiếu:</strong> {{ date('d/m/Y H:i', strtotime($showtime->start_time)) }}</li>
        <li class="list-group-item"><strong>Giá vé:</strong> {{ number_format($showtime->price, 0, ',', '.') }} VNĐ</li>
    </ul>

    @auth
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
        @else
            <a href="{{ route('showtimes.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
        @endif
    @else
        <a href="{{ route('showtimes.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
    @endauth
</div>
@endsection
