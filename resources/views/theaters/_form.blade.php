@php
    $theater ??= null;
@endphp

@csrf

<div class="theater-form-grid">
    <div class="theater-field theater-field-wide">
        <label class="form-label">Tên rạp</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $theater->name ?? '') }}"
               placeholder="Ví dụ: Q&HCINEMA Nguyễn Du"
               required>
    </div>

    <div class="theater-field theater-field-wide">
        <label class="form-label">Địa chỉ</label>
        <input type="text"
               name="address"
               class="form-control"
               value="{{ old('address', $theater->address ?? '') }}"
               placeholder="Nhập địa chỉ rạp">
    </div>

    <div class="theater-field">
        <label class="form-label">Tổng số phòng</label>
        <input type="number"
               name="total_rooms"
               class="form-control"
               min="0"
               value="{{ old('total_rooms', $theater->total_rooms ?? '') }}"
               placeholder="Ví dụ: 6">
    </div>
</div>

<div class="theater-form-actions">
    <a href="{{ route('theaters.index') }}" class="btn btn-secondary theater-form-btn">
        <i class="fa fa-arrow-left"></i> Quay lại
    </a>

    <button type="submit" class="btn btn-primary theater-form-btn">
        <i class="fa {{ isset($theater) ? 'fa-save' : 'fa-plus' }}"></i>
        {{ isset($theater) ? 'Cập nhật rạp' : 'Thêm rạp' }}
    </button>
</div>
