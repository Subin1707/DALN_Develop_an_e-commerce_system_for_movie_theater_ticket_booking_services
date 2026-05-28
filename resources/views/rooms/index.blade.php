@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h4 class="mb-0">
            <i class="fa fa-th-large col_red me-1"></i>
            Danh sách <span class="col_red">Phòng chiếu</span>
        </h4>

        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Thêm phòng
                </a>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th width="25%">Tên phòng</th>
                        <th width="25%">Rạp chiếu</th>
                        <th width="15%">Sức chứa</th>
                        <th width="35%" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td><div class="table-title">{{ $room->name }}</div></td>
                            <td>{{ $room->theater->name ?? 'Không có' }}</td>
                            <td><span class="cinema-badge neutral">{{ $room->capacity ?? $room->seats_count ?? 'N/A' }} ghế</span></td>
                            <td class="text-end">
                                <div class="cinema-actions justify-content-end">
                                    <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-info btn-sm cinema-action-btn">
                                        <i class="fa fa-eye"></i> Xem
                                    </a>

                                    @auth
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning btn-sm cinema-action-btn">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>

                                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này không?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm cinema-action-btn">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="cinema-empty-row">Không có phòng chiếu nào được tìm thấy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
