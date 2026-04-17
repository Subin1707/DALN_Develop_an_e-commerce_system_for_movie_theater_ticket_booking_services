@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Phần thông tin phim chia 2 bên --}}
    <div class="row align-items-start mb-5">
        {{-- BÊN TRÁI: Ảnh poster --}}
        <div class="col-md-5">
            <div >
                @if($movie->poster)
                    <img src="{{ asset( $movie->poster) }}" 
                         alt="{{ $movie->title }}" 
                         class="img-fluid rounded-start w-100">
                @else
                    <img src="{{ asset('img/default_movie.jpg') }}" 
                         alt="No poster" 
                         class="img-fluid rounded-start w-100">
                @endif
            </div>
        </div>

        <div class="col-md-7">
            <h1 class="fw-bold mb-3">{{ $movie->title }}</h1>

            <ul class="list-unstyled">
                <li><strong> Thể loại:</strong> {{ $movie->genre ?? 'N/A' }}</li>
                <li><strong> Thời lượng:</strong> {{ $movie->duration ?? 'N/A' }} phút</li>
                <li><strong> Ngày tạo:</strong> {{ $movie->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</li>
                <li><strong> Cập nhật:</strong> {{ $movie->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</li>
            </ul>

            <p class="mt-3">{{ $movie->description ?? 'Không có mô tả cho phim này.' }}</p>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('movies.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
                
                <a href="{{ route('bookings.choose', ['search' => $movie->title]) }}" class="btn btn-danger">
                     Đặt vé ngay
                </a>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning">
                         Sửa
                    </a>

                    <form action="{{ route('admin.movies.destroy', $movie->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa phim này không?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑️ Xóa</button>

                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="blog_1l3 mt-5">
        <h3>Bình luận gần đây ({{ $comments->total() ?? 0 }})</h3>
    </div>

    <div class="blog_1l5 mt-3">
        @forelse($comments as $comment)
            <div class="blog_1l5i row mb-3">
                
                <div class="col-md-10 col-10">
                    <h5>
                        <a href="#" class="text-decoration-none fw-bold">{{ $comment->author?->name ?? 'Khách' }}</a>
                        <span class="text-muted small">/ {{ $comment->created_at->format('d/m/Y') }}</span>
                    </h5>
                    <p class="font_14"><strong>{{ $comment->title }}</strong><br>{{ $comment->content }}</p>
                </div>
            </div>
            <hr>
        @empty
            <p> Chưa có bình luận nào.</p>
        @endforelse

        <div class="mt-3">
            {{ $comments->links() }}
        </div>
    </div>

    <div class="mt-5">
        <h3>Để lại bình luận</h3>

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('movies.comments.store', $movie->id) }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="movies_id" value="{{ $movie->id }}">
            
            <div class="mb-3">
                <input name="title" value="{{ old('title') }}" class="form-control" placeholder="Tiêu đề bình luận" type="text">
            </div>

            <div class="mb-3">
                <textarea name="content" placeholder="Nội dung bình luận" class="form-control" rows="4">{{ old('content') }}</textarea>
            </div>

            <button type="submit" class="btn btn-danger px-4">
                Gửi bình luận
            </button>
        </form>
    </div>

</div>
@endsection
