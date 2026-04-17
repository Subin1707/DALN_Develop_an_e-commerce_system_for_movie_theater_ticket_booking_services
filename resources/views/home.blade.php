@extends('layouts.app')

@section('title', 'Trang chủ - Rạp Chiếu Phim Online')

@section('content')

<section id="home_intro" class="pt-4 pb-5 bg_grey" style="background-color: #0b0b0b;">
    <div class="container text-light">
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="trend_11">
                    <h4 class="mb-3">
                        <i class="fa fa-film align-middle col_red me-2"></i>
                        <span class="text-white">Chào mừng đến với</span> 
                        <span class="col_red">Rạp Chiếu Phim Online</span>
                    </h4>
                    <p class="text-secondary fs-5">
                        Trải nghiệm điện ảnh đỉnh cao ngay tại nhà – đặt vé nhanh chóng, xem lịch chiếu, 
                        và khám phá những bộ phim hot nhất hôm nay!
                    </p>
                </div>
            </div>
        </div>

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

            {{-- Đặt vé nhanh --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-black rounded-4 border border-danger shadow-lg h-100 hover-shadow">
                    <h3 class="text-danger mb-3">
                        🎟️ Đặt Vé Nhanh
                    </h3>
                    <p class="text-secondary">
                        Chọn rạp, suất chiếu và chỗ ngồi yêu thích chỉ trong vài bước.
                    </p>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="btn btn-danger rounded-pill fw-semibold mt-3 px-4 py-2">
                               Quản lý đặt vé
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
        <div class="row trend_1">
            <div class="col-md-12">
                <div class="trend_11">
                    <h4 class="mb-0"><i class="fa fa-youtube-play align-middle col_red me-1"></i>Trending <span class="col_red">Movies</span></h4>

                </div>
            </div>
        </div> 
    </div>
    

    <div class="row trend_2 mt-4">
            <div class="trend_2i row">
                @forelse ($trendingMovies as $movie)
                    <div class="col-md-3 col-6 mb-4">
                        <div class="trend_2im clearfix position-relative">
                            <div class="trend_2im1 clearfix">
                                <div class="grid">
                                    <figure class="effect-jazz mb-0">
                                        {{-- Nếu có ảnh phim --}}
                                        @if($movie->poster)
                                            <a href="{{ route('movies.show', $movie->id) }}">
                                                <img src="{{ asset($movie->poster) }}" 
                                                    class="w-100" 
                                                    alt="{{ $movie->title }}">
                                            </a>
                                        @else
                                            <a href="{{ route('movies.show', $movie->id) }}">
                                                <img src="{{ asset('img/1.jpg') }}" 
                                                    class="w-100" 
                                                    alt="{{ $movie->title }}">
                                            </a>
                                        @endif
                                    </figure>
                                </div>
                            </div>

                            {{-- Nút xem trailer hoặc chi tiết --}}
                            <div class="trend_2im2 clearfix text-center position-absolute w-100 top-0">
                                <span class="fs-1">
                                    <a class="col_red" href="{{ route('movies.show', $movie->id) }}">
                                        <i class="fa fa-youtube-play"></i>
                                    </a>
                                </span>
                            </div>
                        </div>

                        <div class="trend_2ilast bg_grey p-3 clearfix text-center">
                            <h5>
                                <a class="col_red" href="{{ route('movies.show', $movie->id) }}">
                                    {{ Str::limit($movie->title, 20) }}
                                </a>
                            </h5>
                            <p class="mb-2">{{ Str::limit($movie->description ?? 'Không có mô tả', 50) }}</p>
                            <span class="col_red">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            <p class="mb-0">{{ $movie->genre ?? 'Thể loại không xác định' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Không có phim nào để hiển thị.</p>
                @endforelse
            </div>
        </div>
        


</section>

@endsection
