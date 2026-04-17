@extends('layouts.app')

@section('content')
<div class="container">
   
    <div class="row trend_1">
        <div class="col-md-6 col-6">
            <div class="trend_1l">
                <h4 class="mb-0">
                    <i class="fa fa-building align-middle col_red me-1"></i>
                    Danh sách <span class="col_red">Rạp chiếu</span>
                </h4>
            </div>
        </div>
    </div>
    <br>

    <div class="col-md-5">
                <div class="top_1m">
                    <br>
                    <form action="{{ route('theaters.index') }}" method="GET" class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="form-control bg-black text-white" placeholder="Tìm rạp chiếu...">
                        <button class="btn text-white bg_red rounded-0 border-0" type="submit">Tìm</button>
                    </form>
                </div>
                <br>
    </div>

    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.theaters.create') }}" class="btn btn-primary mb-3">➕ Thêm rạp mới</a>
        @endif
    @endauth

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên rạp</th>
                <th>Địa chỉ</th>
                <th>Tổng số phòng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($theaters as $theater)
                <tr>
                    <td>{{ $theater->name }}</td>
                    <td>{{ $theater->address }}</td>
                    <td>{{ $theater->total_rooms }}</td>
                    <td>
                        <a href="{{ route('theaters.show', $theater) }}" class="btn btn-info btn-sm">👁️</a>

                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.theaters.edit', $theater) }}" class="btn btn-warning btn-sm">✏️</a>
                            <form action="{{ route('admin.theaters.destroy', $theater) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa rạp này?')">🗑️</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Chưa có rạp nào</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
