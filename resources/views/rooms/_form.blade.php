@php
    $room ??= null;
@endphp

<div class="room-form-grid">
    <div class="room-field room-field-wide">
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

    <div class="room-field">
        <label for="name" class="form-label">Tên phòng</label>
        <input type="text"
               name="name"
               id="name"
               class="form-control"
               value="{{ old('name', $room->name ?? '') }}"
               placeholder="Ví dụ: Phòng 1"
               required>
    </div>

    <div class="room-field">
        <label for="capacity" class="form-label">Sức chứa</label>
        <input type="number"
               name="capacity"
               id="capacity"
               min="1"
               class="form-control"
               value="{{ old('capacity', $room->capacity ?? '') }}"
               placeholder="Ví dụ: 96"
               required>
    </div>
</div>

<div class="room-form-actions">
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary room-form-btn">
        <i class="fa fa-arrow-left"></i> Quay lại
    </a>

    <button type="submit" class="btn btn-primary room-form-btn">
        <i class="fa {{ isset($room) ? 'fa-save' : 'fa-plus' }}"></i>
        {{ isset($room) ? 'Cập nhật phòng' : 'Thêm phòng' }}
    </button>
</div>
