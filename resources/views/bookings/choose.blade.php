@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <h4 class="mb-0">
        <i class="fa fa-clock-o align-middle col_red me-1"></i>
        Danh sách <span class="col_red">Suất chiếu</span>
    </h4>

    <form action="{{ route('bookings.choose') }}" method="GET" class="input-group cinema-search" style="max-width: 420px;">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Tìm suất chiếu...">
        <button class="btn text-white bg_red" type="submit">
            <i class="fa fa-search me-1"></i> Tìm
        </button>
    </form>
</div>

@if($showtimes->count() == 0)
    <div class="alert alert-info">Hiện chưa có suất chiếu nào.</div>
@else
    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th>Phim</th>
                        <th>Phòng chiếu</th>
                        <th>Ngày giờ</th>
                        <th>Giá vé</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($showtimes as $showtime)
                        <tr>
                            <td>
                                <div class="table-title">{{ $showtime->movie->title ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="table-code">
                                    <i class="fa fa-building-o"></i>
                                    {{ $showtime->room->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}</td>
                            <td class="table-money">{{ number_format($showtime->price) }} đ</td>
                            <td class="text-end">
                                <a href="{{ route('bookings.create', $showtime->id) }}" class="btn btn-success btn-sm cinema-action-btn">
                                    <i class="fa fa-ticket"></i> Đặt vé
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $showtimes->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
