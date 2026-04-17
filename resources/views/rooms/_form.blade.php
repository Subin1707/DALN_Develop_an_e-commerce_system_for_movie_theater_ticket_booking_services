@php
    $room ??= null;
@endphp

<div class="mb-3">
    <label for="theater_id" class="form-label">Chọn rạp</label>
    <select name="theater_id" id="theater_id" class="form-select" required>
        <option value="">-- Chọn rạp --</option>
        @foreach($theaters as $theater)
            <option value="{{ $theater->id }}"
                {{ old('theater_id', $room->theater_id ?? '') == $theater->id ? 'selected' : '' }}>
                {{ $theater->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Tên phòng</label>
    <input type="text" name="name" id="name"
           class="form-control"
           value="{{ old('name', $room->name ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="capacity" class="form-label">Sức chứa</label>
    <input type="number" name="capacity" id="capacity" min="1"
           class="form-control"
           value="{{ old('capacity', $room->capacity ?? '') }}"
           required>
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($room) ? 'Cập nhật' : 'Thêm mới' }}
</button>

<a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mt-2">⬅️ Quay lại</a>
