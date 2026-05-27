@extends('layouts.app')
@section('content')
<section id="movies-list" class="pt-4 pb-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <h2 class="fw-bold mb-0" style="letter-spacing:1px">
                <i class="fa fa-film text-danger me-2"></i>Danh sách <span class="text-danger">Phim</span>
            </h2>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.movies.create') }}" class="btn btn-danger shadow-sm fw-bold">
                        <i class="fa fa-plus me-1"></i> Thêm phim
                    </a>
                @endif
            @endauth
        </div>

        <div class="row g-4">
            @forelse ($movies as $movie)
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

        <div class="mt-4 d-flex justify-content-center">
            {{ $movies->links() }}
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
</style>
@endsection
