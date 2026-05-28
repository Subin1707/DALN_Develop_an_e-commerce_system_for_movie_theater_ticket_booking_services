@extends('layouts.app')

@section('title', 'Dashboard nhân viên')

@section('content')
<div class="staff-dashboard">
    <section class="staff-hero">
        <div class="staff-hero-copy">
            <span class="staff-kicker">Khu vực nhân viên</span>
            <h1>Xin chào, {{ $user->name }}</h1>
            <p>Theo dõi lịch chiếu, kiểm tra vé và xử lý check-in nhanh tại quầy.</p>
        </div>

        <a href="{{ route('staff.bookings.index') }}" class="staff-primary-action">
            <i class="fa fa-ticket"></i>
            Kiểm tra vé
        </a>
    </section>

    <section class="staff-stat-grid">
        <div class="staff-stat-card showtimes">
            <span class="staff-stat-icon"><i class="fa fa-calendar"></i></span>
            <div>
                <small>Suất chiếu sắp tới</small>
                <strong>{{ number_format($upcomingShowtimes) }}</strong>
            </div>
        </div>

        <div class="staff-stat-card today">
            <span class="staff-stat-icon"><i class="fa fa-ticket"></i></span>
            <div>
                <small>Booking hôm nay</small>
                <strong>{{ number_format($todayBookings) }}</strong>
            </div>
        </div>

        <div class="staff-stat-card total">
            <span class="staff-stat-icon"><i class="fa fa-list"></i></span>
            <div>
                <small>Tổng vé</small>
                <strong>{{ number_format($totalTickets) }}</strong>
            </div>
        </div>
    </section>

    <section class="staff-work-panel">
        <div class="staff-panel-head">
            <div>
                <span class="staff-kicker">Thao tác nhanh</span>
                <h2>Công việc tại quầy</h2>
            </div>
            <p>Ưu tiên kiểm tra thanh toán, xác nhận vé và quét QR check-in cho khách.</p>
        </div>

        <div class="staff-action-grid">
            <a href="{{ route('staff.bookings.index') }}" class="staff-action-card">
                <span><i class="fa fa-search"></i></span>
                <div>
                    <strong>Tra cứu booking</strong>
                    <small>Tìm vé theo mã, khách hàng hoặc trạng thái.</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>

            <a href="{{ route('showtimes.index') }}" class="staff-action-card">
                <span><i class="fa fa-clock-o"></i></span>
                <div>
                    <strong>Xem suất chiếu</strong>
                    <small>Kiểm tra lịch chiếu đang mở bán.</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>

            <a href="{{ route('support.index') }}" class="staff-action-card">
                <span><i class="fa fa-envelope"></i></span>
                <div>
                    <strong>Hỗ trợ khách hàng</strong>
                    <small>Theo dõi ticket và phản hồi yêu cầu.</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .staff-dashboard {
        display: grid;
        gap: 24px;
    }

    .staff-hero,
    .staff-stat-card,
    .staff-work-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .staff-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 30px;
        background:
            linear-gradient(135deg, rgba(14,165,233,.18), rgba(15,23,42,.98) 42%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(233,69,96,.14), transparent 34%);
    }

    .staff-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .staff-hero h1 {
        margin: 8px 0;
        color: #fff;
        font-size: 2.35rem;
        font-weight: 900;
        line-height: 1.12;
    }

    .staff-hero p {
        max-width: 620px;
        margin: 0;
        color: #cbd5e1;
        font-size: 1.03rem;
        line-height: 1.6;
    }

    .staff-primary-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-weight: 900;
        text-decoration: none;
        box-shadow: 0 12px 26px rgba(233,69,96,.28);
        white-space: nowrap;
    }

    .staff-primary-action:hover {
        background: #d6334d;
        color: #fff;
    }

    .staff-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .staff-stat-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 16px;
        min-height: 132px;
        padding: 22px;
        overflow: hidden;
    }

    .staff-stat-card::after {
        content: "";
        position: absolute;
        right: -36px;
        bottom: -36px;
        width: 105px;
        height: 105px;
        border-radius: 50%;
        background: rgba(255,255,255,.045);
    }

    .staff-stat-card.showtimes {
        background: linear-gradient(135deg, #0f172a, rgba(14,165,233,.1));
    }

    .staff-stat-card.today {
        background: linear-gradient(135deg, #0f172a, rgba(233,69,96,.12));
    }

    .staff-stat-card.total {
        background: linear-gradient(135deg, #0f172a, rgba(250,204,21,.1));
    }

    .staff-stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        flex: 0 0 56px;
        border-radius: 8px;
        color: #fff;
        font-size: 1.45rem;
        background: #0284c7;
        box-shadow: 0 12px 26px rgba(2,132,199,.22);
    }

    .staff-stat-card.today .staff-stat-icon {
        background: #e94560;
        box-shadow: 0 12px 26px rgba(233,69,96,.22);
    }

    .staff-stat-card.total .staff-stat-icon {
        background: #ca8a04;
        box-shadow: 0 12px 26px rgba(202,138,4,.2);
    }

    .staff-stat-card small {
        display: block;
        color: #94a3b8;
        font-size: .82rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .staff-stat-card strong {
        display: block;
        margin-top: 6px;
        color: #fff;
        font-size: 1.85rem;
        line-height: 1.1;
    }

    .staff-work-panel {
        padding: 24px;
    }

    .staff-panel-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .staff-panel-head h2 {
        margin: 5px 0 0;
        color: #fff;
        font-size: 1.5rem;
        font-weight: 900;
    }

    .staff-panel-head p {
        max-width: 520px;
        margin: 0;
        color: #94a3b8;
        font-size: .95rem;
        line-height: 1.5;
    }

    .staff-action-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .staff-action-card {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        align-items: center;
        gap: 13px;
        min-height: 112px;
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
        color: #fff;
        text-decoration: none;
        transition: transform .18s ease, background .18s ease, border-color .18s ease;
    }

    .staff-action-card:hover {
        color: #fff;
        transform: translateY(-2px);
        border-color: rgba(14,165,233,.55);
        background: rgba(14,165,233,.11);
    }

    .staff-action-card > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: rgba(14,165,233,.16);
        color: #38bdf8;
        font-size: 1.12rem;
    }

    .staff-action-card strong {
        display: block;
        font-size: 1rem;
    }

    .staff-action-card small {
        display: block;
        margin-top: 4px;
        color: #94a3b8;
        line-height: 1.35;
    }

    .staff-action-card .fa-angle-right {
        color: #64748b;
    }

    @media (max-width: 991.98px) {
        .staff-stat-grid,
        .staff-action-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .staff-hero,
        .staff-panel-head {
            align-items: stretch;
            flex-direction: column;
        }

        .staff-primary-action {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .staff-hero,
        .staff-work-panel {
            padding: 20px;
        }

        .staff-stat-card {
            align-items: flex-start;
            flex-direction: column;
        }

        .staff-hero h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush
