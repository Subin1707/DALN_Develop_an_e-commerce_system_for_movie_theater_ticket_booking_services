@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h4 class="mb-0">
            <i class="fa fa-clock-o col_red me-1"></i>
            Lịch <span class="col_red">Suất chiếu trong tuần</span>
        </h4>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Thêm suất chiếu
            </a>
        @endif
    </div>

    <form action="{{ route('showtimes.index') }}" method="GET" class="input-group cinema-search mb-4" style="max-width: 460px;">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Tìm phim / phòng / ngày...">
        <button class="btn bg_red text-white">
            <i class="fa fa-search me-1"></i> Tìm
        </button>
    </form>

    @php
        $grouped = $showtimes->groupBy(fn($s) => \Carbon\Carbon::parse($s->start_time)->toDateString());
    @endphp

    @forelse ($grouped as $date => $items)
        <div class="cinema-table-card mb-4">
            <div class="cinema-table-toolbar">
                <h5>
                    <i class="fa fa-calendar col_red me-2"></i>
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y') }}
                </h5>
                <span class="cinema-badge neutral">{{ $items->count() }} suất</span>
            </div>

            <div class="table-responsive">
                <table class="table cinema-table align-middle">
                    <thead>
                        <tr>
                            <th>Phim</th>
                            <th>Phòng</th>
                            <th>Giờ chiếu</th>
                            <th>Giá vé</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $showtime)
                            <tr>
                                <td><div class="table-title">{{ $showtime->movie->title ?? 'N/A' }}</div></td>
                                <td><span class="table-code">{{ $showtime->room->name ?? 'N/A' }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</td>
                                <td class="table-money">{{ number_format($showtime->price, 0, ',', '.') }} VNĐ</td>
                                <td class="text-end">
                                    <div class="cinema-actions justify-content-end">
                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.showtimes.show', $showtime) }}" class="btn btn-info btn-sm cinema-action-btn">
                                                <i class="fa fa-eye"></i> Xem
                                            </a>
                                            <a href="{{ route('admin.showtimes.edit', $showtime) }}" class="btn btn-warning btn-sm cinema-action-btn">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>
                                            <form action="{{ route('admin.showtimes.destroy', $showtime) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm cinema-action-btn" onclick="return confirm('Xóa suất chiếu này?')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('showtimes.show', $showtime) }}" class="btn btn-info btn-sm cinema-action-btn">
                                                <i class="fa fa-eye"></i> Xem
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-secondary text-center">
            Không có suất chiếu trong tuần này.
        </div>
    @endforelse

    {{ $showtimes->appends(request()->query())->links() }}
</div>
@endsection
