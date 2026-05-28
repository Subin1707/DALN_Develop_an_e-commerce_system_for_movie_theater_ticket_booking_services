@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container mt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h4 class="mb-0">
            <i class="fa fa-id-badge col_red me-1"></i>
            Quản lý <span class="col_red">Nhân viên</span>
        </h4>

        <a href="{{ route('admin.staffs.create') }}" class="btn btn-success">
            <i class="fa fa-plus me-1"></i> Thêm nhân viên
        </a>
    </div>

    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
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
                            <td><div class="table-title">{{ $staff->name }}</div></td>
                            <td>{{ $staff->email }}</td>
                            <td><span class="cinema-badge info">Nhân viên</span></td>
                            <td class="text-end">
                                <div class="cinema-actions justify-content-end">
                                    <a href="{{ route('admin.staffs.edit', $staff) }}" class="btn btn-sm btn-outline-primary cinema-action-btn">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>

                                    <form action="{{ route('admin.staffs.destroy', $staff) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Xoá nhân viên?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger cinema-action-btn">
                                            <i class="fa fa-trash"></i> Xoá
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
