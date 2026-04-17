@extends('layouts.app')

@section('title', 'Thêm nhân viên')

@section('content')

<div class="container mt-4">

```
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-white mb-0">
        👔 Quản lý nhân viên / Thêm mới
    </h3>
    <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline-secondary">
        ⬅ Quay lại
    </a>
</div>

{{-- Card --}}
<div class="card bg-dark border-secondary shadow-lg">
    <div class="card-header bg-black border-secondary">
        <h5 class="mb-0 text-white">
            ➕ Thông tin nhân viên
        </h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.staffs.store') }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- Tên --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Tên nhân viên
                    </label>
                    <input type="text"
                           name="name"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="Nhập tên nhân viên"
                           value="{{ old('name') }}"
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
                           placeholder="staff@email.com"
                           value="{{ old('email') }}"
                           required>
                </div>

                {{-- Mật khẩu --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Mật khẩu
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="••••••••"
                           required>
                </div>

                {{-- Xác nhận mật khẩu --}}
                <div class="col-md-6">
                    <label class="form-label text-white fw-semibold">
                        Xác nhận mật khẩu
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control bg-black text-white border-secondary"
                           placeholder="Nhập lại mật khẩu"
                           required>
                </div>
            </div>

            {{-- Action --}}
            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.staffs.index') }}"
                   class="btn btn-outline-secondary px-4">
                    Huỷ
                </a>

                <button type="submit"
                        class="btn btn-success px-4">
                    💾 Lưu nhân viên
                </button>
            </div>

        </form>
    </div>
</div>
```

</div>
@endsection
