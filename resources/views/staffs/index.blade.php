@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white">
            👔 Quản lý nhân viên
        </h3>

        <a href="{{ route('admin.staffs.create') }}"
           class="btn btn-success">
            ➕ Thêm nhân viên
        </a>
    </div>

    {{-- CARD --}}
    <div class="card bg-dark border-secondary">
        <div class="card-body p-0">

            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($staffs as $staff)
                    <tr>
                        <td class="fw-semibold">{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>
                            <span class="badge bg-info">
                                Nhân viên
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.staffs.edit', $staff) }}"
                               class="btn btn-sm btn-outline-primary">
                                ✏ Sửa
                            </a>

                            <form action="{{ route('admin.staffs.destroy', $staff) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Xoá nhân viên?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    🗑 Xoá
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
