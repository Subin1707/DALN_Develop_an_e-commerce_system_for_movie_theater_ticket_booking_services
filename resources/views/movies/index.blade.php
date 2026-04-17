@extends('layouts.app')
@section('content')
<section id="trend" class="pt-4 pb-5">
    <div class="container">
        <div class="row trend_1">
            <div class="col-md-6 col-6">
                <div class="trend_1l">
                    <h4 class="mb-0">
                        <i class="fa fa-youtube-play align-middle col_red me-1"></i>
                        Danh sách <span class="col_red">Phim</span>
                    </h4>
                </div>
            </div>
            
        </div>

        <div class="row trend_1">
            <div class="col-md-6 col-6">
                <div class="trend_1l">
                    <h4 class="mb-0">
                       @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.movies.create') }}" class="align-middle  me-1">
                                    ➕Thêm phim
                                </a>
                            @endif
                        @endauth
                    </h4>
                </div>
            </div>
            
        </div>


        <div class="row trend_2 mt-4">
            <div class="trend_2i row">
                @forelse ($movies as $movie)
                    <div class="col-md-3 col-6 mb-4">
                        <div class="trend_2im clearfix position-relative">
                            <div class="trend_2im1 clearfix">
                                <div class="grid">
                                    <figure class="effect-jazz mb-0">
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
        

        {{-- Phân trang --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $movies->links() }}
        </div>
    </div>
</section>
@endsection
