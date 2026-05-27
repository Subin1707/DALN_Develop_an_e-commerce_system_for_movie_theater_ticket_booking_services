<!-- 🔝 Top Bar -->
<section id="top" style="background: linear-gradient(90deg,#1a1a2e 70%,#e94560 100%); box-shadow: 0 2px 16px 0 rgba(233,69,96,0.08);">
    <div class="container py-2">
        <div class="row align-items-center g-2">
            <div class="col-lg-3 col-md-4 col-12 mb-2 mb-md-0">
                <a class="d-flex align-items-center gap-2 text-white fw-bold fs-4 text-decoration-none logo-header" href="{{ route('home') }}">
                    <i class="fa fa-video-camera text-danger fs-3"></i> Q&HCINEMA
                </a>
            </div>
            <div class="col-lg-5 col-md-5 col-12 mb-2 mb-md-0">
                <form action="{{ route('movies.index') }}" method="GET" class="d-flex search-bar shadow-sm rounded-pill overflow-hidden bg-dark">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control border-0 bg-dark text-white px-4 py-2"
                        placeholder="Tìm phim, diễn viên, thể loại..." style="outline:none;">
                    <button class="btn btn-danger px-4 py-2 d-flex align-items-center gap-2 fw-bold" type="submit" style="border-radius:0 999px 999px 0;">
                        <i class="fa fa-search"></i> <span class="d-none d-md-inline">Tìm kiếm</span>
                    </button>
                </form>
            </div>
            <div class="col-lg-4 col-md-3 col-12 text-end">
                <ul class="list-inline mb-0 d-flex justify-content-end align-items-center gap-2">
                    <li class="list-inline-item"><a href="#" class="text-white social-icon-header"><i class="fab fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white social-icon-header"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white social-icon-header"><i class="fab fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="text-white social-icon-header"><i class="fab fa-youtube"></i></a></li>
                    <li class="list-inline-item ms-2">
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                            <i class="fa fa-user text-danger"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
    .search-bar input:focus {
        box-shadow: none;
        background: #23243a;
    }
    .search-bar {
        border-radius: 999px;
        border: 1.5px solid #e94560;
        background: #181828;
    }
    .social-icon-header {
        font-size: 1.2rem;
        transition: color 0.2s, transform 0.2s;
    }
    .social-icon-header:hover {
        color: #e94560;
        transform: scale(1.2) rotate(-8deg);
        text-shadow: 0 2px 8px #e9456044;
    }
    .logo-header {
        letter-spacing: 1px;
        font-family: 'Montserrat',sans-serif;
        font-size: 2rem;
    }
    @media (max-width: 768px) {
        .search-bar input { font-size: 0.95rem; padding-left: 1rem; }
        .logo-header { font-size: 1.3rem; }
    }
</style>

<!-- 🔻 Navbar -->
<section id="header">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm" id="navbar_sticky" style="font-size:1.08rem;">
        <div class="container">
            <a class="navbar-brand text-white fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                <i class="fa fa-video-camera text-danger"></i> Q&HCinema
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">

                    {{-- ================= GUEST ================= --}}
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Phim</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('showtimes.index') }}">Lịch chiếu</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('theaters.index') }}">Rạp</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Đăng ký</a></li>
                    @endguest

                    {{-- ================= AUTH ================= --}}
                    @auth
                        {{-- ===== ADMIN ===== --}}
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.movies.index') }}">Phim</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.theaters.index') }}">Rạp</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.rooms.index') }}">Phòng</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.showtimes.index') }}">Suất chiếu</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.bookings.index') }}">Đặt vé</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.staffs.index') }}">Nhân viên</a></li>

                        {{-- ===== USER / STAFF ===== --}}
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Phim</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('showtimes.index') }}">Suất chiếu</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('theaters.index') }}">Rạp</a></li>

                            @if(auth()->user()->role === 'user')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bookings.choose') }}">🎟 Đặt vé</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('bookings.history') }}">📜 Vé của tôi</a>
                                </li>
                            @else
                                {{-- ✅ FIX TẠI ĐÂY --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('staff.bookings.index') }}">📋 Quản lý vé</a>
                                </li>
                            @endif
                        @endif

                        {{-- CSKH --}}
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-semibold"
                               href="{{ route('support.index') }}">
                                🆘 CSKH
                            </a>
                        </li>

                        {{-- USER INFO --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                👤 Tài khoản
                            </a>
                        </li>

                        {{-- LOGOUT --}}
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-white" style="padding: 0.5rem 1rem; border: none; background: none; cursor: pointer;">🚪 Đăng xuất</button>
                            </form>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
</section>
