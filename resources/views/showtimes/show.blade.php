@extends('layouts.app')

@section('content')
@php
    $startTime = \Carbon\Carbon::parse($showtime->start_time);
    $backRoute = route('showtimes.index');

    if (Auth::check() && Auth::user()->role === 'admin') {
        $backRoute = route('admin.showtimes.index');
    }
@endphp

<div class="showtime-detail-page">
    <section class="showtime-hero">
        <div class="showtime-icon">
            <i class="fa fa-clock-o"></i>
        </div>

        <div class="showtime-copy">
            <span class="showtime-kicker">Chi tiết suất chiếu</span>
            <h1>{{ $showtime->movie->title ?? 'N/A' }}</h1>
            <p>{{ $startTime->translatedFormat('l, d/m/Y') }} lúc {{ $startTime->format('H:i') }}</p>
        </div>

        <div class="showtime-price">
            <span>Giá vé</span>
            <strong>{{ number_format($showtime->price, 0, ',', '.') }} VNĐ</strong>
        </div>
    </section>

    <section class="showtime-info-grid">
        <div class="showtime-info-card">
            <span><i class="fa fa-hashtag"></i></span>
            <div>
                <small>Mã suất chiếu</small>
                <strong>#{{ $showtime->id }}</strong>
            </div>
        </div>

        <div class="showtime-info-card">
            <span><i class="fa fa-building"></i></span>
            <div>
                <small>Phòng chiếu</small>
                <strong>{{ $showtime->room->name ?? 'N/A' }}</strong>
            </div>
        </div>

        <div class="showtime-info-card">
            <span><i class="fa fa-calendar"></i></span>
            <div>
                <small>Ngày chiếu</small>
                <strong>{{ $startTime->format('d/m/Y') }}</strong>
            </div>
        </div>

        <div class="showtime-info-card">
            <span><i class="fa fa-clock-o"></i></span>
            <div>
                <small>Giờ chiếu</small>
                <strong>{{ $startTime->format('H:i') }}</strong>
            </div>
        </div>
    </section>

    <div class="showtime-actions">
        <a href="{{ $backRoute }}" class="btn btn-secondary showtime-action-btn">
            <i class="fa fa-arrow-left"></i> Quay lại
        </a>

        <div class="cinema-actions">
            @if($canBook ?? false)
                <a href="{{ route('bookings.create', $showtime) }}" class="btn btn-danger showtime-action-btn">
                    <i class="fa fa-ticket"></i> Đặt vé
                </a>
            @elseif(Auth::check() && Auth::user()->role === 'user')
                <span class="btn btn-outline-secondary showtime-action-btn disabled">
                    <i class="fa fa-ban"></i> Suất chiếu đã qua giờ
                </span>
            @endif

            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.showtimes.edit', $showtime) }}" class="btn btn-warning showtime-action-btn">
                    <i class="fa fa-pencil"></i> Chỉnh sửa
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .showtime-detail-page {
        display: grid;
        gap: 22px;
    }

    .showtime-hero {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        gap: 22px;
        align-items: center;
        padding: 28px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
        box-shadow: 0 22px 55px rgba(0,0,0,.28);
    }

    .showtime-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 82px;
        height: 82px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 2.35rem;
        box-shadow: 0 16px 34px rgba(233,69,96,.32);
    }

    .showtime-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .showtime-copy h1 {
        margin: 6px 0 8px;
        color: #fff;
        font-size: 2.35rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .showtime-copy p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1.05rem;
    }

    .showtime-price {
        min-width: 170px;
        padding: 16px;
        border: 1px solid rgba(250,204,21,.2);
        border-radius: 8px;
        background: rgba(250,204,21,.1);
        text-align: center;
    }

    .showtime-price span {
        display: block;
        color: #e5e7eb;
        font-weight: 900;
        text-transform: uppercase;
        font-size: .82rem;
    }

    .showtime-price strong {
        display: block;
        margin-top: 6px;
        color: #facc15;
        font-size: 1.35rem;
    }

    .showtime-info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .showtime-info-card,
    .showtime-actions {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .showtime-info-card {
        display: flex;
        gap: 14px;
        min-height: 110px;
        padding: 18px;
        align-items: center;
    }

    .showtime-info-card > span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 1.25rem;
    }

    .showtime-info-card small {
        display: block;
        color: #94a3b8;
        font-size: .8rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .showtime-info-card strong {
        display: block;
        margin-top: 5px;
        color: #fff;
        font-size: 1.05rem;
        line-height: 1.35;
    }

    .showtime-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px;
    }

    .showtime-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
    }

    @media (max-width: 991.98px) {
        .showtime-hero,
        .showtime-info-grid {
            grid-template-columns: 1fr 1fr;
        }

        .showtime-copy {
            grid-column: span 1;
        }

        .showtime-price {
            text-align: left;
        }
    }

    @media (max-width: 575.98px) {
        .showtime-hero,
        .showtime-info-grid {
            grid-template-columns: 1fr;
        }

        .showtime-hero {
            padding: 20px;
        }

        .showtime-copy h1 {
            font-size: 1.9rem;
        }

        .showtime-actions {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>
@endpush
