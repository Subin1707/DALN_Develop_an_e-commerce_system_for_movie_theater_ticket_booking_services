@extends('layouts.app')

@section('content')
<div class="theater-detail-page">
    <section class="theater-hero">
        <div class="theater-icon">
            <i class="fa fa-building"></i>
        </div>

        <div class="theater-copy">
            <span class="theater-kicker">Thông tin rạp</span>
            <h1>{{ $theater->name }}</h1>
            <p>{{ $theater->address }}</p>
        </div>

        <div class="theater-room-badge">
            <strong>{{ $theater->total_rooms }}</strong>
            <span>phòng chiếu</span>
        </div>
    </section>

    <section class="theater-info-grid">
        <div class="theater-info-card">
            <span><i class="fa fa-map-marker"></i></span>
            <div>
                <small>Địa chỉ</small>
                <strong>{{ $theater->address }}</strong>
            </div>
        </div>

        <div class="theater-info-card">
            <span><i class="fa fa-th-large"></i></span>
            <div>
                <small>Tổng số phòng</small>
                <strong>{{ $theater->total_rooms }} phòng</strong>
            </div>
        </div>

        <div class="theater-info-card">
            <span><i class="fa fa-calendar"></i></span>
            <div>
                <small>Ngày tạo</small>
                <strong>{{ $theater->created_at->format('d/m/Y') }}</strong>
            </div>
        </div>
    </section>

    <div class="theater-actions">
        <a href="{{ route('theaters.index') }}" class="btn btn-secondary theater-action-btn">
            <i class="fa fa-arrow-left"></i> Quay lại danh sách
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.theaters.edit', $theater) }}" class="btn btn-warning theater-action-btn">
                    <i class="fa fa-pencil"></i> Chỉnh sửa
                </a>
            @endif
        @endauth
    </div>
</div>
@endsection

@push('styles')
<style>
    .theater-detail-page {
        display: grid;
        gap: 22px;
    }

    .theater-hero {
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

    .theater-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 82px;
        height: 82px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 2.3rem;
        box-shadow: 0 16px 34px rgba(233,69,96,.32);
    }

    .theater-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .theater-copy h1 {
        margin: 6px 0 8px;
        color: #fff;
        font-size: 2.35rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .theater-copy p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1.05rem;
    }

    .theater-room-badge {
        min-width: 138px;
        padding: 16px;
        border: 1px solid rgba(250,204,21,.2);
        border-radius: 8px;
        background: rgba(250,204,21,.1);
        text-align: center;
    }

    .theater-room-badge strong {
        display: block;
        color: #facc15;
        font-size: 2rem;
        line-height: 1;
    }

    .theater-room-badge span {
        color: #e5e7eb;
        font-weight: 900;
    }

    .theater-info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .theater-info-card,
    .theater-actions {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .theater-info-card {
        display: flex;
        gap: 14px;
        min-height: 110px;
        padding: 18px;
        align-items: center;
    }

    .theater-info-card > span {
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

    .theater-info-card small {
        display: block;
        color: #94a3b8;
        font-size: .8rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .theater-info-card strong {
        display: block;
        margin-top: 5px;
        color: #fff;
        font-size: 1.05rem;
        line-height: 1.35;
    }

    .theater-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 16px;
    }

    .theater-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
    }

    @media (max-width: 991.98px) {
        .theater-hero,
        .theater-info-grid {
            grid-template-columns: 1fr;
        }

        .theater-room-badge {
            text-align: left;
        }
    }

    @media (max-width: 575.98px) {
        .theater-hero {
            padding: 20px;
        }

        .theater-copy h1 {
            font-size: 1.9rem;
        }

        .theater-actions {
            flex-direction: column;
        }
    }
</style>
@endpush
