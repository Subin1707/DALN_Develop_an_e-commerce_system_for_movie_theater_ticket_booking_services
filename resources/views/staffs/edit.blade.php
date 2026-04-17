@extends('layouts.app')

@section('title', 'Sửa nhân viên')

@section('content')

<div class="container mt-4">

```
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white mb-0">
        ✏️ Quản lý nhân viên / Sửa thông tin
    </h3>
    <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline-secondary">
        ⬅ Quay lại
    </a>
</div>

{{-- Card --}}
<div class="card bg-dark border-secondary shadow-lg">
    <div class="card-header bg-black border-secondary">
        <h5 class="mb-0 text-white">
            👤 Thông tin nhân viên
        </h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.staffs.update', $staff->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- Tên --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Tên nhân viên
                    </label>
                    <input type="text"
                           name="name"
                           class="form-control bg-black text-white border-secondary"
                           value="{{ old('name', $staff->name) }}"
                           required>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           class="form-control bg-black text-white border-secondary"
                           value="{{ old('email', $staff->email) }}"
                           required>
                </div>

                {{-- Mật khẩu --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Mật khẩu mới
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="Để trống nếu không đổi">
                </div>

                {{-- Xác nhận --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Xác nhận mật khẩu
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="Nhập lại mật khẩu">
                </div>
            </div>

            {{-- Action --}}
            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.staffs.index') }}"
                   class="btn btn-outline-secondary px-4">
                    Huỷ
                </a>

                <button type="submit"
                        class="btn btn-warning px-4 text-dark fw-semibold">
                    💾 Cập nhật
                </button>
            </div>

        </form>
    </div>
</div>
```

</div>
@endsection
