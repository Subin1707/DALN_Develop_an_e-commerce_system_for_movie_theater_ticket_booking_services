@php
    $currentUser = auth()->user();
    $userInitial = $currentUser ? strtoupper(mb_substr($currentUser->name, 0, 1)) : null;
@endphp

<header class="cinema-header">
    <nav class="navbar navbar-expand-lg navbar-dark cinema-navbar" id="navbar_sticky">
        <div class="container">
            <a class="cinema-brand" href="{{ route('home') }}">
                <span class="brand-mark"><i class="fa fa-video-camera"></i></span>
                <span class="brand-copy">
                    <strong>Q&HCinema</strong>
                    <small>Vé xem phim</small>
                </span>
            </a>

            <button class="navbar-toggler cinema-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Mở menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav cinema-nav mx-lg-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Phim</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('showtimes.index') }}">Lịch chiếu</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('theaters.index') }}">Rạp</a></li>
                    @endguest

                    @auth
                        @if($currentUser->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.movies.index') }}">Phim</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.theaters.index') }}">Rạp</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.rooms.index') }}">Phòng</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.showtimes.index') }}">Suất chiếu</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.bookings.index') }}">Đặt vé</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.staffs.index') }}">Nhân viên</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Phim</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('showtimes.index') }}">Suất chiếu</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('theaters.index') }}">Rạp</a></li>

                            @if($currentUser->role === 'user')
                                <li class="nav-item"><a class="nav-link nav-ticket" href="{{ route('bookings.choose') }}">Đặt vé</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('bookings.history') }}">Vé của tôi</a></li>
                            @else
                                <li class="nav-item"><a class="nav-link nav-ticket" href="{{ route('staff.bookings.index') }}">Quản lý vé</a></li>
                            @endif
                        @endif

                        <li class="nav-item">
                            <a class="nav-link support-link" href="{{ route('support.index') }}">CSKH</a>
                        </li>
                    @endauth
                </ul>

                <div class="header-actions">
                    <form action="{{ route('movies.index') }}" method="GET" class="header-search">
                        <i class="fa fa-search"></i>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Tìm phim...">
                        <button type="submit">Tìm</button>
                    </form>

                    @guest
                        <div class="guest-actions">
                            <a class="btn btn-login" href="{{ route('login') }}">
                                <i class="fa fa-sign-in"></i>
                                <span>Đăng nhập</span>
                            </a>
                            <a class="btn btn-register" href="{{ route('register') }}">Đăng ký</a>
                        </div>
                    @endguest

                    @auth
                        <div class="dropdown account-dropdown">
                            <a class="account-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="account-avatar">{{ $userInitial }}</span>
                                <span class="account-name">
                                    <strong>{{ $currentUser->name }}</strong>
                                    <small>{{ ucfirst($currentUser->role) }}</small>
                                </span>
                                <i class="fa fa-angle-down"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end account-menu" aria-labelledby="accountDropdown">
                                <div class="account-menu-head">
                                    <span class="account-avatar account-avatar-lg">{{ $userInitial }}</span>
                                    <div>
                                        <strong>{{ $currentUser->name }}</strong>
                                        <small>{{ $currentUser->email }}</small>
                                    </div>
                                </div>

                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fa fa-user-circle me-2"></i> Tài khoản
                                </a>

                                @if($currentUser->role === 'user')
                                    <a class="dropdown-item" href="{{ route('bookings.history') }}">
                                        <i class="fa fa-ticket me-2"></i> Vé đã đặt
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa fa-sign-out me-2"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    .cinema-header {
        position: sticky;
        top: 0;
        z-index: 1030;
        background:
            linear-gradient(90deg, rgba(15,23,42,.98), rgba(31,41,55,.96) 58%, rgba(136,34,62,.95));
        border-bottom: 1px solid rgba(255,255,255,.08);
        box-shadow: 0 16px 40px rgba(0,0,0,.28);
    }

    .cinema-navbar {
        min-height: 78px;
        padding: 10px 0;
    }

    .cinema-brand {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        min-width: 185px;
        color: #fff;
        text-decoration: none;
    }

    .cinema-brand:hover {
        color: #fff;
    }

    .brand-mark {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        box-shadow: 0 10px 24px rgba(233,69,96,.36);
    }

    .brand-mark i {
        font-size: 1.35rem;
    }

    .brand-copy {
        display: grid;
        line-height: 1.05;
    }

    .brand-copy strong {
        font-size: 1.35rem;
        font-weight: 900;
        letter-spacing: .2px;
    }

    .brand-copy small {
        margin-top: 4px;
        color: #facc15;
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .9px;
    }

    .cinema-toggler {
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 8px;
        padding: 8px 10px;
    }

    .cinema-nav {
        align-items: center;
        gap: 4px;
    }

    .cinema-nav .nav-link {
        position: relative;
        color: rgba(255,255,255,.76);
        font-weight: 800;
        padding: 10px 12px;
        border-radius: 8px;
        white-space: nowrap;
    }

    .cinema-nav .nav-link:hover,
    .cinema-nav .nav-link:focus {
        color: #fff;
        background: rgba(255,255,255,.08);
    }

    .cinema-nav .nav-link::after {
        content: "";
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 5px;
        height: 2px;
        background: #e94560;
        border-radius: 999px;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform .18s ease;
    }

    .cinema-nav .nav-link:hover::after {
        transform: scaleX(1);
    }

    .cinema-nav .nav-ticket {
        color: #fff;
        background: rgba(233,69,96,.18);
    }

    .support-link {
        color: #facc15 !important;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-left: 14px;
    }

    .header-search {
        display: flex;
        align-items: center;
        width: 260px;
        height: 42px;
        padding-left: 14px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 999px;
        background: rgba(15,23,42,.64);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.02);
    }

    .header-search:focus-within {
        border-color: rgba(233,69,96,.95);
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.14);
    }

    .header-search i {
        color: #e94560;
        margin-right: 8px;
    }

    .header-search input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: #fff;
        font-weight: 600;
    }

    .header-search input::placeholder {
        color: rgba(255,255,255,.48);
    }

    .header-search button {
        align-self: stretch;
        min-width: 58px;
        border: 0;
        border-radius: 999px;
        background: #e94560;
        color: #fff;
        font-weight: 900;
    }

    .guest-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-login,
    .btn-register {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        border-radius: 999px;
        padding: 0 16px;
        font-weight: 900;
        white-space: nowrap;
    }

    .btn-login {
        border: 1px solid rgba(255,255,255,.3);
        color: #fff;
        background: rgba(255,255,255,.06);
    }

    .btn-login:hover {
        border-color: #fff;
        color: #fff;
        background: rgba(255,255,255,.12);
    }

    .btn-login i {
        margin-right: 7px;
    }

    .btn-register {
        border: 0;
        color: #fff;
        background: #e94560;
        box-shadow: 0 10px 22px rgba(233,69,96,.32);
    }

    .btn-register:hover {
        color: #fff;
        background: #d6334d;
    }

    .account-toggle {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        max-width: 240px;
        padding: 5px 10px 5px 5px;
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 999px;
        color: #fff;
        text-decoration: none;
        background: rgba(15,23,42,.5);
    }

    .account-toggle:hover {
        color: #fff;
        border-color: rgba(255,255,255,.36);
        background: rgba(15,23,42,.72);
    }

    .account-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        flex: 0 0 32px;
        border-radius: 50%;
        background: #facc15;
        color: #111827;
        font-weight: 900;
    }

    .account-name {
        display: grid;
        min-width: 0;
        line-height: 1.08;
    }

    .account-name strong {
        max-width: 128px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: .9rem;
    }

    .account-name small {
        color: #facc15;
        font-size: .7rem;
        font-weight: 800;
    }

    .account-menu {
        min-width: 286px;
        padding: 10px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 20px 50px rgba(0,0,0,.35);
    }

    .account-menu-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 10px 14px;
        color: #fff;
    }

    .account-avatar-lg {
        width: 42px;
        height: 42px;
        flex-basis: 42px;
    }

    .account-menu-head small {
        display: block;
        max-width: 190px;
        overflow: hidden;
        color: #94a3b8;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .account-menu .dropdown-item {
        border-radius: 6px;
        color: #e5e7eb;
        padding: 9px 10px;
        font-weight: 800;
    }

    .account-menu .dropdown-item:hover,
    .account-menu .dropdown-item:focus {
        background: rgba(233,69,96,.14);
        color: #fff;
    }

    .account-menu .dropdown-item.text-danger {
        color: #f87171 !important;
    }

    .account-menu .dropdown-divider {
        border-color: rgba(255,255,255,.1);
    }

    @media (max-width: 1199.98px) {
        .header-search {
            width: 210px;
        }

        .brand-copy small {
            display: none;
        }
    }

    @media (max-width: 991.98px) {
        .cinema-navbar {
            min-height: 68px;
        }

        .navbar-collapse {
            margin-top: 14px;
            padding: 14px;
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 8px;
            background: rgba(15,23,42,.95);
        }

        .cinema-nav {
            align-items: stretch;
            gap: 4px;
        }

        .cinema-nav .nav-link {
            padding: 10px 12px;
        }

        .cinema-nav .nav-link::after {
            display: none;
        }

        .header-actions {
            display: grid;
            gap: 10px;
            margin: 12px 0 0;
        }

        .header-search {
            width: 100%;
        }

        .guest-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .account-toggle {
            max-width: none;
            width: 100%;
            justify-content: space-between;
        }

        .account-name {
            margin-right: auto;
        }

        .account-menu {
            width: 100%;
            min-width: 0;
        }
    }

    @media (max-width: 575.98px) {
        .cinema-brand {
            min-width: 0;
        }

        .brand-copy strong {
            font-size: 1.1rem;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
        }

        .guest-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
