<!-- 🔝 Top Bar -->
<section id="top">
    <div class="container">
        <div class="row top_1 align-items-center">
            <div class="col-md-3">
                <div class="top_1l pt-1">
                    <h3 class="mb-0">
                        <a class="text-white" href="{{ route('home') }}">
                            <i class="fa fa-video-camera col_red me-1"></i> Q&HCINEMA
                        </a>
                    </h3>
                </div>
            </div>

            <div class="col-md-5">
                <form action="{{ route('movies.index') }}" method="GET" class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control bg-black text-white"
                           placeholder="Tìm phim...">
                    <button class="btn bg_red text-white rounded-0" type="submit">
                        Tìm
                    </button>
                </form>
            </div>

            <div class="col-md-4 text-end">
                <ul class="social-network social-circle mb-0">
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li>
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                            <i class="fa fa-user"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- 🔻 Navbar -->
<section id="header">
    <nav class="navbar navbar-expand-md navbar-dark bg-black" id="navbar_sticky">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">
                <i class="fa fa-video-camera col_red me-1"></i> Q&HCinema
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
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link text-white">🚪 Đăng xuất</button>
                            </form>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
</section>
