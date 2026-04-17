@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">💺 Chi tiết phòng chiếu #{{ $room->id }}</h1>

    <div class="card shadow-sm border-0 rounded-3 p-4">
        <ul class="list-unstyled mb-3 fs-5">
            <li><strong>🏷️ Tên phòng:</strong> {{ $room->name }}</li>
            <li><strong>🎥 Rạp chiếu:</strong> {{ $room->theater->name ?? 'Không có' }}</li>
            <li><strong>💺 Sức chứa:</strong> {{ $room->capacity ?? $room->seats_count ?? 'N/A' }}</li>
        </ul>
    </div>

    <div class="d-flex flex-wrap gap-2 mt-4">
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
            ⬅️ Quay lại danh sách
        </a>

        @auth
            @if(Auth::user()->role === 'admin')
=                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning">
                    ✏️ Sửa
                </a>

                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                      onsubmit="return confirm('⚠️ Bạn có chắc chắn muốn xóa phòng này không?')"
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        🗑️ Xóa
                    </button>
                </form>
            @endif
        @endauth
    </div>
</div>
@endsection
