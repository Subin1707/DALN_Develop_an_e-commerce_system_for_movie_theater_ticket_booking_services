@extends('layouts.app')

@section('content')
<div class="booking-choose-page">
    <section class="booking-choose-hero">
        <div>
            <span class="booking-kicker">Đặt vé</span>
            <h1>Chọn suất chiếu</h1>
            <p>Tìm phim đang chiếu, chọn giờ phù hợp và bắt đầu đặt ghế.</p>
        </div>

        <form action="{{ route('bookings.choose') }}" method="GET" class="booking-search">
            <i class="fa fa-search"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Tìm phim hoặc suất chiếu...">
            <button type="submit">Tìm</button>
        </form>
    </section>

    @if(session('error'))
        <div class="booking-alert">
            <i class="fa fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($showtimes->count() == 0)
        <section class="booking-empty">
            <i class="fa fa-calendar-times-o"></i>
            <h2>Chưa có suất chiếu phù hợp</h2>
            <p>Thử tìm bằng tên phim khác hoặc quay lại sau khi lịch chiếu được cập nhật.</p>
        </section>
    @else
        <section class="booking-table-card">
            <div class="booking-table-head">
                <div>
                    <span class="booking-kicker">Danh sách</span>
                    <h2>Suất chiếu có thể đặt</h2>
                </div>
                <span class="cinema-badge neutral">{{ $showtimes->total() }} suất</span>
            </div>

            <div class="table-responsive">
                <table class="table cinema-table align-middle booking-choose-table">
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
                            @php
                                $startTime = \Carbon\Carbon::parse($showtime->start_time);
                            @endphp
                            <tr>
                                <td>
                                    <div class="booking-movie-cell">
                                        <span class="movie-icon"><i class="fa fa-film"></i></span>
                                        <div>
                                            <div class="table-title">{{ $showtime->movie->title ?? 'N/A' }}</div>
                                            <div class="table-muted">{{ $startTime->translatedFormat('l') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="table-code">
                                        <i class="fa fa-building-o"></i>
                                        {{ $showtime->room->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="booking-time">
                                        <i class="fa fa-clock-o"></i>
                                        {{ $startTime->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td class="table-money">{{ number_format($showtime->price, 0, ',', '.') }} đ</td>
                                <td class="text-end">
                                    <a href="{{ route('bookings.create', $showtime->id) }}" class="btn btn-success btn-sm cinema-action-btn booking-btn">
                                        <i class="fa fa-ticket"></i> Đặt vé
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <div class="booking-pagination">
            <span>Hiển thị {{ $showtimes->count() }} / {{ number_format($showtimes->total()) }} suất</span>
            {{ $showtimes->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .booking-choose-page {
        display: grid;
        gap: 20px;
    }

    .booking-choose-hero,
    .booking-table-card,
    .booking-empty {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .booking-choose-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(320px, 480px);
        align-items: center;
        gap: 22px;
        padding: 28px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 42%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.14), transparent 34%);
    }

    .booking-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .booking-choose-hero h1,
    .booking-table-head h2 {
        margin: 7px 0;
        color: #fff;
        font-weight: 900;
    }

    .booking-choose-hero h1 {
        font-size: 2.2rem;
        line-height: 1.1;
    }

    .booking-choose-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .booking-search {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        align-items: center;
        min-height: 48px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background: #111827;
    }

    .booking-search i {
        color: #e94560;
        padding-left: 15px;
    }

    .booking-search input {
        min-width: 0;
        height: 48px;
        border: 0;
        outline: 0;
        background: transparent;
        color: #fff;
        padding: 0 12px;
    }

    .booking-search button {
        height: 48px;
        border: 0;
        background: #e94560;
        color: #fff;
        padding: 0 18px;
        font-weight: 900;
    }

    .booking-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1px solid rgba(248,113,113,.34);
        border-radius: 8px;
        background: rgba(127,29,29,.25);
        color: #fecaca;
        font-weight: 800;
    }

    .booking-alert i {
        color: #fb7185;
    }

    .booking-table-card {
        overflow: hidden;
    }

    .booking-table-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 17px 18px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        background: linear-gradient(90deg, rgba(30,41,59,.94), rgba(15,23,42,.94));
    }

    .booking-table-head h2 {
        font-size: 1.3rem;
    }

    .booking-choose-table tbody td {
        padding-top: 16px;
        padding-bottom: 16px;
    }

    .booking-movie-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .movie-icon {
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

    .booking-time {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #e5e7eb;
        font-weight: 900;
        white-space: nowrap;
    }

    .booking-time i {
        color: #38bdf8;
    }

    .booking-btn {
        min-width: 86px;
    }

    .booking-empty {
        padding: 50px 20px;
        text-align: center;
    }

    .booking-empty i {
        color: #e94560;
        font-size: 2.8rem;
        margin-bottom: 14px;
    }

    .booking-empty h2 {
        color: #fff;
        font-weight: 900;
    }

    .booking-empty p {
        margin: 8px auto 0;
        max-width: 520px;
        color: #94a3b8;
        font-size: 1rem;
    }

    .booking-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .booking-pagination > span {
        color: #94a3b8;
        font-size: .95rem;
    }

    @media (max-width: 991.98px) {
        .booking-choose-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .booking-table-head,
        .booking-pagination {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>
@endpush
