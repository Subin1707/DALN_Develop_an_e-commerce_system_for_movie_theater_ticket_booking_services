@extends('layouts.app')

@section('title', 'Trang chủ - Rạp Chiếu Phim Online')

@section('content')


<section id="home_intro" class="pt-5 pb-5" style="background: linear-gradient(120deg,#1a1a2e 70%,#e94560 100%); border-radius:0 0 32px 32px; box-shadow: 0 4px 32px 0 rgba(233,69,96,0.10);">
    <div class="container text-light">
        <div class="row mb-4 justify-content-center align-items-center">
            <div class="col-lg-8 col-md-10 col-12 text-center">
                <div class="p-4 p-md-5 rounded-4 shadow-lg banner-welcome mx-auto" style="background:rgba(0,0,0,0.45);backdrop-filter:blur(2px);">
                    <h1 class="mb-3 fw-bold" style="font-size:2.5rem;letter-spacing:1px">
                        <i class="fa fa-film align-middle text-danger me-2"></i>
                        <span class="text-white">Chào mừng đến với</span> 
                        <span class="text-danger">Rạp Chiếu Phim Online</span>
                    </h1>
                    <p class="text-light fs-5 mb-4">
                        Trải nghiệm điện ảnh đỉnh cao ngay tại nhà – đặt vé nhanh chóng, xem lịch chiếu, 
                        và khám phá những bộ phim hot nhất hôm nay!
                    </p>
                    <a href="#popular" class="btn btn-lg btn-danger rounded-pill px-5 py-3 fw-bold shadow mt-2 banner-cta">
                        Khám phá phim hot <i class="fa fa-arrow-down ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
<style>
    .banner-welcome {
        border-radius: 32px;
        box-shadow: 0 8px 32px 0 rgba(233,69,96,0.18);
        animation: fadeInDown 1.2s;
    }
    .banner-cta:hover {
        background: #fff !important;
        color: #e94560 !important;
        border: 2px solid #e94560;
        transform: scale(1.05);
    }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-40px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

        <div class="row text-center popular_1 mt-4">
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        🍿 Phim Đang Chiếu
                    </h3>
                    <p class="text-secondary">
                        Cập nhật liên tục những bộ phim bom tấn đang hot tại rạp.
                    </p>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.movies.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                                Quản lý phim
                            </a>
                        @else
                            <a href="{{ route('movies.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                                Xem ngay
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                           Xem ngay
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Đặt vé nhanh / quản lý booking --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <i class="fa fa-ticket me-1"></i> Quản Lý Booking
                            @else
                                <i class="fa fa-ticket me-1"></i> Đặt Vé Nhanh
                            @endif
                        @else
                            <i class="fa fa-ticket me-1"></i> Đặt Vé Nhanh
                        @endauth
                    </h3>
                    <p class="text-secondary">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                Theo dõi, chỉnh sửa và quản lý trạng thái các booking trong hệ thống.
                            @else
                                Chọn rạp, suất chiếu và chỗ ngồi yêu thích chỉ trong vài bước.
                            @endif
                        @else
                            Chọn rạp, suất chiếu và chỗ ngồi yêu thích chỉ trong vài bước.
                        @endauth
                    </p>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                               Xem booking
                            </a>
                        @else
                            <a href="{{ route('bookings.choose') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                               Đặt vé
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                           Đặt vé
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Ưu đãi thành viên --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        ⭐ Ưu Đãi Thành Viên
                    </h3>
                    <p class="text-secondary">
                        Nhận ưu đãi và điểm thưởng khi đăng ký tài khoản khách hàng thân thiết.
                    </p>

                    @auth
                        <span class="btn btn-secondary rounded-pill fw-semibold mt-3 px-4 py-2">
                            Bạn đã là thành viên
                        </span>
                    @else
                        <a href="{{ route('register') }}" 
                           class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                           Tham gia ngay
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>


<section id="popular" class="pt-4 pb-5 bg_grey">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h2 class="fw-bold mb-0" style="letter-spacing:1px">
                <i class="fa fa-fire text-danger me-2"></i>Trending <span class="text-danger">Movies</span>
            </h2>
        </div>

        <div class="row g-4">
            @forelse ($trendingMovies as $movie)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card movie-card h-100 border-0 shadow-sm position-relative overflow-hidden">
                        <a href="{{ route('movies.show', $movie->id) }}">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('img/1.jpg') }}" class="card-img-top movie-poster" alt="{{ $movie->title }}">
                        </a>
                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-light btn-trailer position-absolute top-0 end-0 m-2 rounded-circle shadow" title="Xem trailer/chi tiết">
                            <i class="fa fa-play text-danger"></i>
                        </a>
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="card-title mb-1 fw-bold">
                                <a class="text-danger text-decoration-none" href="{{ route('movies.show', $movie->id) }}">
                                    {{ Str::limit($movie->title, 20) }}
                                </a>
                            </h5>
                            <p class="card-text small mb-2" style="min-height:38px">{{ Str::limit($movie->description ?? 'Không có mô tả', 50) }}</p>
                            <div class="mb-2">
                                <span class="text-warning">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                            </div>
                            <span class="badge bg-secondary">{{ $movie->genre ?? 'Thể loại không xác định' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Không có phim nào để hiển thị.</p>
            @endforelse
        </div>
    </div>
</section>

<style>
    .movie-card {
        border-radius: 18px;
        transition: transform 0.2s, box-shadow 0.2s;
        background: #23243a;
        color: #fff;
    }
    .movie-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 8px 32px 0 rgba(233,69,96,0.18);
        z-index: 2;
    }
    .movie-poster {
        border-radius: 18px 18px 0 0;
        height: 320px;
        object-fit: cover;
        background: #111;
    }
    .btn-trailer {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.92;
        transition: background 0.2s, transform 0.2s;
    }
    .btn-trailer:hover {
        background: #e94560;
        color: #fff;
        transform: scale(1.15) rotate(-8deg);
    }
    .card-title a {
        transition: color 0.2s;
    }
    .card-title a:hover {
        color: #e94560 !important;
    }
    .badge.bg-secondary {
        background: #2d2e4a !important;
        color: #fff;
        font-size: 0.95em;
        border-radius: 8px;
        padding: 0.5em 1em;
    }
    @media (max-width: 768px) {
        .movie-poster {
            height: 200px;
        }
    }
    .btn, .btn-danger, .btn-light, .btn-secondary {
        border-radius: 999px !important;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 12px 0 rgba(233,69,96,0.08);
        transition: background 0.2s, color 0.2s, transform 0.2s;
    }
    .btn-danger:hover, .btn-light:hover, .btn-secondary:hover {
        background: #e94560 !important;
        color: #fff !important;
        transform: scale(1.07);
    }
</style>

@endsection
