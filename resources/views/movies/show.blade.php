@extends('layouts.app')

@section('content')
@php
    $poster = $movie->poster ? asset($movie->poster) : asset('img/default_movie.jpg');
@endphp

<div class="movie-detail-page">
    <section class="movie-hero-detail">
        <div class="movie-poster-card">
            <img src="{{ $poster }}" alt="{{ $movie->title }}">
        </div>

        <div class="movie-detail-content">
            <span class="movie-kicker">Chi tiết phim</span>
            <h1>{{ $movie->title }}</h1>

            <div class="movie-meta-pills">
                <span><i class="fa fa-tags"></i> {{ $movie->genre ?? 'N/A' }}</span>
                <span><i class="fa fa-clock-o"></i> {{ $movie->duration ?? 'N/A' }} phút</span>
                <span><i class="fa fa-calendar"></i> {{ $movie->created_at?->format('d/m/Y') ?? 'N/A' }}</span>
            </div>

            <div class="movie-description">
                {{ $movie->description ?? 'Không có mô tả cho phim này.' }}
            </div>

            <div class="movie-actions">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-danger movie-primary-btn">
                        <i class="fa fa-sign-in"></i> Đăng nhập để đặt vé
                    </a>
                @endguest

                @auth
                    @if(Auth::user()->role === 'user')
                        <a href="{{ route('bookings.choose', ['search' => $movie->title]) }}" class="btn btn-danger movie-primary-btn">
                            <i class="fa fa-ticket"></i> Đặt vé ngay
                        </a>
                    @endif
                @endauth

                <a href="{{ route('movies.index') }}" class="btn btn-outline-light movie-secondary-btn">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning movie-secondary-btn">
                        <i class="fa fa-pencil"></i> Sửa
                    </a>

                    <form action="{{ route('admin.movies.destroy', $movie->id) }}"
                          method="POST"
                          onsubmit="return confirm('Bạn có chắc muốn xóa phim này không?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger movie-secondary-btn">
                            <i class="fa fa-trash"></i> Xóa
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <section class="movie-comments-layout">
        <div class="comments-panel">
            <div class="section-title-row">
                <div>
                    <span class="movie-kicker">Cộng đồng</span>
                    <h3>Bình luận gần đây</h3>
                </div>
                <span class="cinema-badge neutral">{{ $comments->total() ?? 0 }} bình luận</span>
            </div>

            <div class="comment-list">
                @forelse($comments as $comment)
                    <article class="comment-card">
                        <div class="comment-avatar">
                            {{ strtoupper(mb_substr($comment->author?->name ?? 'K', 0, 1)) }}
                        </div>
                        <div class="comment-body">
                            <div class="comment-head">
                                <strong>{{ $comment->author?->name ?? 'Khách' }}</strong>
                                <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h5>{{ $comment->title }}</h5>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </article>
                @empty
                    <div class="comment-empty">
                        <i class="fa fa-comments-o"></i>
                        <h5>Chưa có bình luận nào</h5>
                        <p>Hãy là người đầu tiên chia sẻ cảm nhận về bộ phim này.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $comments->links() }}
            </div>
        </div>

        <aside class="comment-form-panel">
            <span class="movie-kicker">Chia sẻ cảm nhận</span>
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

            <form action="{{ route('movies.comments.store', $movie->id) }}" method="POST" class="movie-comment-form">
                @csrf
                <input type="hidden" name="movies_id" value="{{ $movie->id }}">

                <div class="mb-3">
                    <label class="form-label">Tiêu đề</label>
                    <input name="title"
                           value="{{ old('title') }}"
                           class="form-control"
                           placeholder="Ví dụ: Phim rất đáng xem"
                           type="text">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content"
                              placeholder="Viết cảm nhận của bạn..."
                              class="form-control"
                              rows="5">{{ old('content') }}</textarea>
                </div>

                <button type="submit" class="btn btn-danger w-100 movie-primary-btn">
                    <i class="fa fa-paper-plane"></i> Gửi bình luận
                </button>
            </form>
        </aside>
    </section>
</div>
@endsection

@push('styles')
<style>
    .movie-detail-page {
        display: grid;
        gap: 34px;
    }

    .movie-hero-detail {
        display: grid;
        grid-template-columns: 330px minmax(0, 1fr);
        gap: 34px;
        align-items: stretch;
        padding: 28px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 38%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
        box-shadow: 0 22px 55px rgba(0,0,0,.28);
    }

    .movie-poster-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background: #111827;
        box-shadow: 0 22px 45px rgba(0,0,0,.38);
        min-height: 460px;
    }

    .movie-poster-card::after {
        content: "";
        position: absolute;
        inset: 0;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 8px;
        pointer-events: none;
    }

    .movie-poster-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .movie-detail-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 460px;
    }

    .movie-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .movie-detail-content h1 {
        margin: 10px 0 16px;
        color: #fff;
        font-size: 3rem;
        font-weight: 900;
        line-height: 1.05;
    }

    .movie-meta-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 22px;
    }

    .movie-meta-pills span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 999px;
        background: rgba(255,255,255,.06);
        color: #e5e7eb;
        font-weight: 800;
    }

    .movie-meta-pills i {
        color: #fb7185;
    }

    .movie-description {
        max-width: 760px;
        padding: 18px;
        border-left: 3px solid #e94560;
        border-radius: 0 8px 8px 0;
        background: rgba(255,255,255,.04);
        color: #d1d5db;
        font-size: 1.05rem;
        line-height: 1.7;
    }

    .movie-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 24px;
    }

    .movie-primary-btn,
    .movie-secondary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        border-radius: 8px;
        padding-inline: 18px;
        font-weight: 900;
    }

    .movie-comments-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 380px;
        gap: 24px;
        align-items: start;
    }

    .comments-panel,
    .comment-form-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .comments-panel {
        padding: 22px;
    }

    .section-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }

    .section-title-row h3,
    .comment-form-panel h3 {
        margin: 5px 0 0;
        color: #fff;
        font-size: 1.55rem;
        font-weight: 900;
    }

    .comment-list {
        display: grid;
        gap: 14px;
    }

    .comment-card {
        display: flex;
        gap: 14px;
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .comment-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 50%;
        background: #facc15;
        color: #111827;
        font-weight: 900;
    }

    .comment-head {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin-bottom: 5px;
    }

    .comment-head strong {
        color: #fff;
    }

    .comment-head span {
        color: #94a3b8;
        font-size: .88rem;
    }

    .comment-body h5 {
        margin: 0 0 6px;
        color: #facc15;
        font-size: 1rem;
    }

    .comment-body p {
        margin: 0;
        color: #cbd5e1;
        font-size: .98rem;
        line-height: 1.55;
    }

    .comment-empty {
        display: grid;
        justify-items: center;
        gap: 8px;
        padding: 42px 20px;
        border: 1px dashed rgba(255,255,255,.14);
        border-radius: 8px;
        color: #94a3b8;
        text-align: center;
    }

    .comment-empty i {
        color: #fb7185;
        font-size: 2.2rem;
    }

    .comment-empty h5 {
        margin: 0;
        color: #fff;
    }

    .comment-form-panel {
        padding: 22px;
        position: sticky;
        top: 98px;
    }

    .movie-comment-form {
        margin-top: 18px;
    }

    .movie-comment-form .form-label {
        color: #e5e7eb;
        font-weight: 800;
    }

    .movie-comment-form .form-control {
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background: #111827;
        color: #fff;
    }

    .movie-comment-form .form-control:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.12);
        background: #111827;
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .movie-hero-detail,
        .movie-comments-layout {
            grid-template-columns: 1fr;
        }

        .movie-poster-card {
            max-width: 360px;
            min-height: 500px;
            margin: 0 auto;
            width: 100%;
        }

        .movie-detail-content {
            min-height: 0;
        }

        .comment-form-panel {
            position: static;
        }
    }

    @media (max-width: 575.98px) {
        .movie-hero-detail {
            padding: 18px;
        }

        .movie-detail-content h1 {
            font-size: 2.15rem;
        }

        .movie-actions .btn {
            width: 100%;
        }

        .section-title-row {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush
