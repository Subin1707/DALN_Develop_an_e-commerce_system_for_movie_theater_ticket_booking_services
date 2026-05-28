@extends('layouts.app')

@section('content')
@php
    $grouped = $showtimes->groupBy(fn($s) => \Carbon\Carbon::parse($s->start_time)->toDateString());
    $totalCurrentPage = $showtimes->count();
@endphp

<div class="showtime-index-page">
    <section class="showtime-index-hero">
        <div>
            <span class="showtime-index-kicker">Lịch chiếu</span>
            <h1>Suất chiếu trong tuần</h1>
            <p>Tra cứu nhanh lịch chiếu, phòng chiếu và giá vé đang mở bán.</p>
        </div>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.showtimes.create') }}" class="showtime-add-btn">
                <i class="fa fa-plus"></i>
                Thêm suất chiếu
            </a>
        @endif
    </section>

    <section class="showtime-filter-panel">
        <form action="{{ route('showtimes.index') }}" method="GET" class="showtime-search">
            <i class="fa fa-search"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Tìm phim, phòng hoặc ngày chiếu...">
            <button type="submit">Tìm</button>
        </form>

        @if(request('search'))
            <a href="{{ route('showtimes.index') }}" class="showtime-clear-filter">
                <i class="fa fa-times"></i>
                Xóa lọc
            </a>
        @endif
    </section>

    @forelse ($grouped as $date => $items)
        <section class="showtime-day-card">
            <div class="showtime-day-head">
                <div>
                    <span>{{ \Carbon\Carbon::parse($date)->translatedFormat('l') }}</span>
                    <h2>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h2>
                </div>
                <span class="cinema-badge neutral">{{ $items->count() }} suất</span>
            </div>

            <div class="table-responsive">
                <table class="table cinema-table align-middle showtime-table">
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
                                <td>
                                    <div class="showtime-movie-cell">
                                        <span class="movie-dot"><i class="fa fa-film"></i></span>
                                        <div>
                                            <div class="table-title">{{ $showtime->movie->title ?? 'N/A' }}</div>
                                            <div class="table-muted">ID suất #{{ $showtime->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="table-code">{{ $showtime->room->name ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="showtime-time">
                                        <i class="fa fa-clock-o"></i>
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                    </span>
                                </td>
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
        </section>
    @empty
        <section class="showtime-empty">
            <i class="fa fa-calendar-times-o"></i>
            <h2>Không có suất chiếu phù hợp</h2>
            <p>Thử đổi từ khóa tìm kiếm hoặc quay lại sau khi lịch chiếu được cập nhật.</p>
        </section>
    @endforelse

    @if($showtimes->hasPages())
        <div class="showtime-pagination">
            <span>Hiển thị {{ $totalCurrentPage }} / {{ number_format($showtimes->total()) }} kết quả</span>
            {{ $showtimes->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .showtime-index-page {
        display: grid;
        gap: 20px;
    }

    .showtime-index-hero,
    .showtime-filter-panel,
    .showtime-day-card,
    .showtime-empty {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .showtime-index-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        padding: 28px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 42%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(14,165,233,.16), transparent 34%);
    }

    .showtime-index-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .showtime-index-hero h1 {
        margin: 7px 0;
        color: #fff;
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .showtime-index-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .showtime-add-btn,
    .showtime-clear-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;
    }

    .showtime-add-btn {
        padding: 0 18px;
        background: #e94560;
        color: #fff;
        box-shadow: 0 12px 26px rgba(233,69,96,.28);
    }

    .showtime-add-btn:hover {
        background: #d6334d;
        color: #fff;
    }

    .showtime-filter-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px;
        background: rgba(15,23,42,.82);
    }

    .showtime-search {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        align-items: center;
        width: min(100%, 620px);
        min-height: 46px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background: #111827;
    }

    .showtime-search i {
        color: #e94560;
        padding-left: 15px;
    }

    .showtime-search input {
        min-width: 0;
        height: 46px;
        border: 0;
        outline: 0;
        background: transparent;
        color: #fff;
        padding: 0 12px;
    }

    .showtime-search button {
        height: 46px;
        border: 0;
        background: #e94560;
        color: #fff;
        padding: 0 18px;
        font-weight: 900;
    }

    .showtime-clear-filter {
        padding: 0 14px;
        border: 1px solid rgba(255,255,255,.12);
        color: #cbd5e1;
    }

    .showtime-clear-filter:hover {
        border-color: rgba(233,69,96,.55);
        color: #fff;
        background: rgba(233,69,96,.12);
    }

    .showtime-day-card {
        overflow: hidden;
    }

    .showtime-day-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 17px 18px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        background: linear-gradient(90deg, rgba(30,41,59,.94), rgba(15,23,42,.94));
    }

    .showtime-day-head span:first-child {
        display: block;
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .showtime-day-head h2 {
        margin: 4px 0 0;
        color: #fff;
        font-size: 1.28rem;
        font-weight: 900;
    }

    .showtime-table tbody td {
        padding-top: 16px;
        padding-bottom: 16px;
    }

    .showtime-movie-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .movie-dot {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
    }

    .showtime-time {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #e5e7eb;
        font-weight: 900;
    }

    .showtime-time i {
        color: #38bdf8;
    }

    .showtime-empty {
        padding: 50px 20px;
        text-align: center;
    }

    .showtime-empty i {
        color: #e94560;
        font-size: 2.8rem;
        margin-bottom: 14px;
    }

    .showtime-empty h2 {
        color: #fff;
        font-weight: 900;
    }

    .showtime-empty p {
        margin: 8px auto 0;
        max-width: 520px;
        color: #94a3b8;
        font-size: 1rem;
    }

    .showtime-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding-top: 4px;
    }

    .showtime-pagination > span {
        color: #94a3b8;
        font-size: .95rem;
    }

    .showtime-pagination nav {
        margin-left: auto;
    }

    @media (max-width: 767.98px) {
        .showtime-index-hero,
        .showtime-filter-panel,
        .showtime-day-head,
        .showtime-pagination {
            align-items: stretch;
            flex-direction: column;
        }

        .showtime-add-btn,
        .showtime-clear-filter,
        .showtime-search {
            width: 100%;
        }

        .showtime-pagination nav {
            margin-left: 0;
        }
    }
</style>
@endpush
