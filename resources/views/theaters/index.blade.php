@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h4 class="mb-0">
            <i class="fa fa-building align-middle col_red me-1"></i>
            Danh sách <span class="col_red">Rạp chiếu</span>
        </h4>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.theaters.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Thêm rạp mới
                </a>
            @endif
        @endauth
    </div>

    <form action="{{ route('theaters.index') }}" method="GET" class="input-group cinema-search mb-4" style="max-width: 420px;">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Tìm rạp chiếu...">
        <button class="btn text-white bg_red" type="submit">
            <i class="fa fa-search me-1"></i> Tìm
        </button>
    </form>

    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th>Tên rạp</th>
                        <th>Địa chỉ</th>
                        <th>Tổng số phòng</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($theaters as $theater)
                        <tr>
                            <td><div class="table-title">{{ $theater->name }}</div></td>
                            <td>{{ $theater->address }}</td>
                            <td><span class="cinema-badge neutral">{{ $theater->total_rooms }} phòng</span></td>
                            <td class="text-end">
                                <div class="cinema-actions justify-content-end">
                                    <a href="{{ route('theaters.show', $theater) }}" class="btn btn-info btn-sm cinema-action-btn">
                                        <i class="fa fa-eye"></i> Xem
                                    </a>

                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.theaters.edit', $theater) }}" class="btn btn-warning btn-sm cinema-action-btn">
                                            <i class="fa fa-pencil"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.theaters.destroy', $theater) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm cinema-action-btn" onclick="return confirm('Xóa rạp này?')">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="cinema-empty-row">Chưa có rạp nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
