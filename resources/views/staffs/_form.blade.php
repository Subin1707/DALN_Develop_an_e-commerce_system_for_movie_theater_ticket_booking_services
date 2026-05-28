@php
    $staff ??= null;
@endphp

@csrf

<div class="staff-form-grid">
    <div class="staff-field">
        <label class="form-label">Tên nhân viên</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $staff->name ?? '') }}"
               placeholder="Nhập tên nhân viên"
               required>
    </div>

    <div class="staff-field">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email', $staff->email ?? '') }}"
               placeholder="staff@qhcinema.com"
               required>
    </div>

    <div class="staff-field">
        <label class="form-label">
            {{ isset($staff) ? 'Mật khẩu mới' : 'Mật khẩu' }}
        </label>
        <input type="password"
               name="password"
               class="form-control"
               placeholder="{{ isset($staff) ? 'Để trống nếu không đổi' : 'Nhập mật khẩu' }}"
               {{ isset($staff) ? '' : 'required' }}>
        @if(isset($staff))
            <small class="field-hint">Chỉ nhập nếu muốn đổi mật khẩu.</small>
        @endif
    </div>

    <div class="staff-field">
        <label class="form-label">Xác nhận mật khẩu</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               placeholder="Nhập lại mật khẩu"
               {{ isset($staff) ? '' : 'required' }}>
    </div>
</div>

<div class="staff-form-actions">
    <a href="{{ route('admin.staffs.index') }}" class="btn btn-secondary staff-form-btn">
        <i class="fa fa-arrow-left"></i> Quay lại
    </a>

    <button type="submit" class="btn btn-primary staff-form-btn">
        <i class="fa {{ isset($staff) ? 'fa-save' : 'fa-plus' }}"></i>
        {{ isset($staff) ? 'Cập nhật nhân viên' : 'Lưu nhân viên' }}
    </button>
</div>
