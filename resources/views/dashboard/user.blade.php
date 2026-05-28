@extends('layouts.app')

@section('title', 'Thông tin khách hàng')

@section('content')
<div class="customer-dashboard">
    <section class="customer-hero">
        <div class="customer-avatar">
            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
        </div>
        <div>
            <span class="customer-kicker">Tài khoản khách hàng</span>
            <h1>Xin chào, {{ $user->name }}</h1>
            <p>Quản lý hồ sơ, đặt vé mới và theo dõi các vé đã mua tại Q&HCinema.</p>
        </div>
    </section>

    <section class="customer-grid">
        <div class="customer-profile-card">
            <div class="customer-card-head">
                <span><i class="fa fa-user"></i></span>
                <div>
                    <small>Hồ sơ</small>
                    <h2>Thông tin cá nhân</h2>
                </div>
            </div>

            <div class="customer-profile-list">
                <div>
                    <span>Email</span>
                    <strong>{{ $user->email }}</strong>
                </div>
                <div>
                    <span>Vai trò</span>
                    <strong>{{ $user->roleLabel() }}</strong>
                </div>
                <div>
                    <span>Tổng vé</span>
                    <strong>{{ number_format($totalBooked) }} vé</strong>
                </div>
            </div>
        </div>

        <div class="customer-action-card">
            <div class="customer-card-head">
                <span><i class="fa fa-ticket"></i></span>
                <div>
                    <small>Thao tác nhanh</small>
                    <h2>Chức năng</h2>
                </div>
            </div>

            <div class="customer-action-list">
                <a href="{{ route('showtimes.index') }}">
                    <i class="fa fa-calendar"></i>
                    <div>
                        <strong>Xem lịch chiếu</strong>
                        <small>Tra cứu phim và suất chiếu trong tuần.</small>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>

                <a href="{{ route('bookings.choose') }}">
                    <i class="fa fa-shopping-cart"></i>
                    <div>
                        <strong>Đặt vé mới</strong>
                        <small>Chọn suất chiếu, ghế và phương thức thanh toán.</small>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>

                <a href="{{ route('bookings.history') }}">
                    <i class="fa fa-list"></i>
                    <div>
                        <strong>Vé của tôi</strong>
                        <small>Xem {{ number_format($totalBooked) }} vé đã đặt.</small>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="customer-booking-panel">
        <div class="customer-section-head">
            <div>
                <span class="customer-kicker">Lịch sử gần đây</span>
                <h2>Vé gần đây</h2>
            </div>
            <a href="{{ route('bookings.history') }}">Xem tất cả</a>
        </div>

        @if($bookings->isEmpty())
            <div class="customer-empty">
                <i class="fa fa-ticket"></i>
                <h3>Bạn chưa đặt vé nào</h3>
                <p>Hãy chọn một suất chiếu phù hợp để bắt đầu đặt vé.</p>
                <a href="{{ route('bookings.choose') }}">Đặt vé ngay</a>
            </div>
        @else
            <div class="customer-booking-grid">
                @foreach($bookings as $booking)
                    @php
                        $statusClass = match($booking->status) {
                            'confirmed' => 'success',
                            'pending' => 'warning',
                            'cancelled' => 'danger',
                            default => 'neutral',
                        };
                    @endphp

                    <article class="customer-ticket-card">
                        <div class="ticket-top">
                            <span class="ticket-icon"><i class="fa fa-film"></i></span>
                            <span class="cinema-badge {{ $statusClass }}">{{ strtoupper($booking->status) }}</span>
                        </div>

                        <h3>{{ $booking->showtime->movie->title ?? 'Không rõ phim' }}</h3>

                        <div class="ticket-meta">
                            <span><i class="fa fa-map-marker"></i> {{ $booking->room_code ?? $booking->showtime->room->name ?? 'N/A' }}</span>
                            <span><i class="fa fa-clock-o"></i> {{ optional($booking->showtime)->start_time ? \Carbon\Carbon::parse($booking->showtime->start_time)->format('d/m/Y H:i') : 'N/A' }}</span>
                            <span><i class="fa fa-ticket"></i> Ghế {{ $booking->seats }}</span>
                        </div>

                        <div class="ticket-footer">
                            <strong>{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</strong>
                            <a href="{{ route('bookings.show', $booking) }}">Chi tiết</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
    .customer-dashboard {
        display: grid;
        gap: 24px;
    }

    .customer-hero,
    .customer-profile-card,
    .customer-action-card,
    .customer-booking-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .customer-hero {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 30px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 42%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.13), transparent 34%);
    }

    .customer-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 76px;
        height: 76px;
        flex: 0 0 76px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
        box-shadow: 0 14px 30px rgba(233,69,96,.3);
    }

    .customer-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .customer-hero h1,
    .customer-section-head h2 {
        margin: 7px 0;
        color: #fff;
        font-weight: 900;
    }

    .customer-hero h1 {
        font-size: 2.35rem;
        line-height: 1.12;
    }

    .customer-hero p {
        max-width: 680px;
        margin: 0;
        color: #cbd5e1;
        font-size: 1.03rem;
        line-height: 1.6;
    }

    .customer-grid {
        display: grid;
        grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
        gap: 18px;
    }

    .customer-profile-card,
    .customer-action-card,
    .customer-booking-panel {
        padding: 22px;
    }

    .customer-card-head {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 18px;
    }

    .customer-card-head > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 1.25rem;
    }

    .customer-card-head small {
        color: #facc15;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .customer-card-head h2 {
        margin: 3px 0 0;
        color: #fff;
        font-size: 1.35rem;
        font-weight: 900;
    }

    .customer-profile-list {
        display: grid;
        gap: 11px;
    }

    .customer-profile-list div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 13px 14px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .customer-profile-list span,
    .customer-action-list small,
    .ticket-meta span {
        color: #94a3b8;
    }

    .customer-profile-list strong {
        color: #fff;
        text-align: right;
    }

    .customer-action-list {
        display: grid;
        gap: 10px;
    }

    .customer-action-list a {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        align-items: center;
        gap: 13px;
        padding: 14px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
        color: #fff;
        text-decoration: none;
        transition: transform .18s ease, background .18s ease, border-color .18s ease;
    }

    .customer-action-list a:hover {
        color: #fff;
        transform: translateY(-2px);
        border-color: rgba(233,69,96,.55);
        background: rgba(233,69,96,.12);
    }

    .customer-action-list a > i:first-child {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: rgba(14,165,233,.16);
        color: #38bdf8;
    }

    .customer-action-list strong {
        display: block;
        color: #fff;
    }

    .customer-action-list small {
        display: block;
        margin-top: 3px;
        line-height: 1.35;
    }

    .customer-action-list .fa-angle-right {
        color: #64748b;
    }

    .customer-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .customer-section-head h2 {
        font-size: 1.5rem;
    }

    .customer-section-head a,
    .customer-empty a,
    .ticket-footer a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 0 14px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-weight: 900;
        text-decoration: none;
    }

    .customer-section-head a:hover,
    .customer-empty a:hover,
    .ticket-footer a:hover {
        background: #d6334d;
        color: #fff;
    }

    .customer-booking-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 14px;
    }

    .customer-ticket-card {
        display: grid;
        gap: 13px;
        min-height: 250px;
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .ticket-top,
    .ticket-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .ticket-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
    }

    .customer-ticket-card h3 {
        margin: 0;
        color: #fff;
        font-size: 1.08rem;
        font-weight: 900;
        line-height: 1.35;
    }

    .ticket-meta {
        display: grid;
        gap: 8px;
    }

    .ticket-meta span {
        display: flex;
        gap: 8px;
        line-height: 1.35;
    }

    .ticket-meta i {
        color: #38bdf8;
        margin-top: 3px;
    }

    .ticket-footer {
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .ticket-footer strong {
        color: #facc15;
        font-size: .95rem;
    }

    .ticket-footer a {
        min-height: 34px;
        padding-inline: 12px;
        font-size: .9rem;
    }

    .customer-empty {
        padding: 40px 18px;
        border: 1px dashed rgba(255,255,255,.14);
        border-radius: 8px;
        text-align: center;
        background: rgba(255,255,255,.025);
    }

    .customer-empty i {
        color: #e94560;
        font-size: 2.6rem;
        margin-bottom: 12px;
    }

    .customer-empty h3 {
        color: #fff;
        font-weight: 900;
    }

    .customer-empty p {
        color: #94a3b8;
        font-size: 1rem;
    }

    @media (max-width: 1199.98px) {
        .customer-booking-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .customer-grid {
            grid-template-columns: 1fr;
        }

        .customer-booking-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .customer-hero,
        .customer-section-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .customer-section-head a {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .customer-hero,
        .customer-profile-card,
        .customer-action-card,
        .customer-booking-panel {
            padding: 20px;
        }

        .customer-booking-grid {
            grid-template-columns: 1fr;
        }

        .customer-profile-list div,
        .ticket-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .customer-hero h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush
