@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <section class="admin-hero">
        <div>
            <span class="admin-kicker">Bảng điều khiển</span>
            <h1>Quản trị hệ thống</h1>
            <p>Xin chào <strong>{{ $user->name }}</strong>, đây là tổng quan hoạt động của Q&HCinema.</p>
        </div>

        <a href="{{ route('admin.dashboard.revenue') }}" class="admin-hero-action">
            <i class="fa fa-line-chart"></i>
            Xem doanh thu
        </a>
    </section>

    <section class="admin-stat-grid">
        <div class="admin-stat-card">
            <span class="stat-icon users"><i class="fa fa-users"></i></span>
            <div>
                <small>Người dùng</small>
                <strong>{{ number_format($userCount) }}</strong>
            </div>
        </div>

        <div class="admin-stat-card">
            <span class="stat-icon movies"><i class="fa fa-film"></i></span>
            <div>
                <small>Phim</small>
                <strong>{{ number_format($movieCount) }}</strong>
            </div>
        </div>

        <div class="admin-stat-card">
            <span class="stat-icon tickets"><i class="fa fa-ticket"></i></span>
            <div>
                <small>Vé đã bán</small>
                <strong>{{ number_format($ticketCount) }}</strong>
            </div>
        </div>

        <div class="admin-stat-card revenue">
            <span class="stat-icon money"><i class="fa fa-money"></i></span>
            <div>
                <small>Doanh thu</small>
                <strong>{{ number_format($revenue) }} đ</strong>
            </div>
        </div>
    </section>

    <section class="admin-quick-panel">
        <div class="quick-panel-head">
            <div>
                <span class="admin-kicker">Thao tác nhanh</span>
                <h3>Quản lý dữ liệu</h3>
            </div>
            <p>Truy cập nhanh các module quản trị thường dùng.</p>
        </div>

        <div class="admin-action-grid">
            <a href="{{ route('admin.movies.index') }}" class="admin-action-card">
                <span><i class="fa fa-film"></i></span>
                <div>
                    <strong>Quản lý phim</strong>
                    <small>Thêm, sửa, xóa thông tin phim</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>

            <a href="{{ route('admin.showtimes.index') }}" class="admin-action-card">
                <span><i class="fa fa-clock-o"></i></span>
                <div>
                    <strong>Suất chiếu</strong>
                    <small>Sắp lịch chiếu và giá vé</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="admin-action-card">
                <span><i class="fa fa-ticket"></i></span>
                <div>
                    <strong>Booking</strong>
                    <small>Theo dõi vé và thanh toán</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>

            <a href="{{ route('admin.staffs.index') }}" class="admin-action-card">
                <span><i class="fa fa-id-badge"></i></span>
                <div>
                    <strong>Nhân viên</strong>
                    <small>Quản lý tài khoản nhân viên</small>
                </div>
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .admin-dashboard {
        display: grid;
        gap: 24px;
    }

    .admin-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 30px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 42%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.14), transparent 34%);
        box-shadow: 0 22px 55px rgba(0,0,0,.28);
    }

    .admin-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .admin-hero h1 {
        margin: 8px 0;
        color: #fff;
        font-size: 2.4rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .admin-hero p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1.03rem;
    }

    .admin-hero p strong {
        color: #fff;
    }

    .admin-hero-action {
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

    .admin-hero-action:hover {
        background: #d6334d;
        color: #fff;
    }

    .admin-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .admin-stat-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
        min-height: 128px;
        padding: 22px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .admin-stat-card::after {
        content: "";
        position: absolute;
        right: -35px;
        bottom: -35px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
    }

    .admin-stat-card.revenue {
        background: linear-gradient(135deg, #0f172a, rgba(250,204,21,.1));
        border-color: rgba(250,204,21,.18);
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        flex: 0 0 54px;
        border-radius: 8px;
        color: #fff;
        font-size: 1.5rem;
    }

    .stat-icon.users {
        background: #e94560;
    }

    .stat-icon.movies {
        background: #7c3aed;
    }

    .stat-icon.tickets {
        background: #0284c7;
    }

    .stat-icon.money {
        background: #ca8a04;
    }

    .admin-stat-card small {
        display: block;
        color: #94a3b8;
        font-size: .82rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .admin-stat-card strong {
        display: block;
        margin-top: 6px;
        color: #fff;
        font-size: 1.7rem;
        line-height: 1.1;
    }

    .admin-quick-panel {
        padding: 24px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .quick-panel-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .quick-panel-head h3 {
        margin: 5px 0 0;
        color: #fff;
        font-size: 1.5rem;
        font-weight: 900;
    }

    .quick-panel-head p {
        margin: 0;
        color: #94a3b8;
        font-size: .95rem;
    }

    .admin-action-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .admin-action-card {
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

    .admin-action-card:hover {
        color: #fff;
        transform: translateY(-2px);
        border-color: rgba(233,69,96,.55);
        background: rgba(233,69,96,.12);
    }

    .admin-action-card > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 1.18rem;
    }

    .admin-action-card strong {
        display: block;
        font-size: 1rem;
    }

    .admin-action-card small {
        display: block;
        margin-top: 4px;
        color: #94a3b8;
        line-height: 1.35;
    }

    .admin-action-card .fa-angle-right {
        color: #64748b;
    }

    @media (max-width: 1199.98px) {
        .admin-stat-grid,
        .admin-action-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .admin-hero,
        .quick-panel-head {
            align-items: stretch;
            flex-direction: column;
        }

        .admin-hero-action {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .admin-stat-grid,
        .admin-action-grid {
            grid-template-columns: 1fr;
        }

        .admin-hero,
        .admin-quick-panel {
            padding: 20px;
        }

        .admin-hero h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush
