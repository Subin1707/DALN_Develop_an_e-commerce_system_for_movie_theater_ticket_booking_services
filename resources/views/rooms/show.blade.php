@extends('layouts.app')

@section('content')
@php
    $capacity = $room->capacity ?? $room->seats_count ?? 'N/A';
@endphp

<div class="room-detail-page">
    <section class="room-hero">
        <div class="room-icon">
            <i class="fa fa-th-large"></i>
        </div>

        <div class="room-copy">
            <span class="room-kicker">Chi tiết phòng chiếu</span>
            <h1>{{ $room->name }}</h1>
            <p>{{ $room->theater->name ?? 'Chưa gán rạp chiếu' }}</p>
        </div>

        <div class="room-capacity-badge">
            <strong>{{ $capacity }}</strong>
            <span>ghế</span>
        </div>
    </section>

    <section class="room-info-grid">
        <div class="room-info-card">
            <span><i class="fa fa-hashtag"></i></span>
            <div>
                <small>Mã phòng</small>
                <strong>#{{ $room->id }}</strong>
            </div>
        </div>

        <div class="room-info-card">
            <span><i class="fa fa-tag"></i></span>
            <div>
                <small>Tên phòng</small>
                <strong>{{ $room->name }}</strong>
            </div>
        </div>

        <div class="room-info-card">
            <span><i class="fa fa-building"></i></span>
            <div>
                <small>Rạp chiếu</small>
                <strong>{{ $room->theater->name ?? 'Không có' }}</strong>
            </div>
        </div>

        <div class="room-info-card">
            <span><i class="fa fa-users"></i></span>
            <div>
                <small>Sức chứa</small>
                <strong>{{ $capacity }} ghế</strong>
            </div>
        </div>
    </section>

    <div class="room-actions">
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary room-action-btn">
            <i class="fa fa-arrow-left"></i> Quay lại danh sách
        </a>

        @auth
            @if(Auth::user()->role === 'admin')
                <div class="cinema-actions">
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning room-action-btn">
                        <i class="fa fa-pencil"></i> Sửa
                    </a>

                    <form action="{{ route('admin.rooms.destroy', $room) }}"
                          method="POST"
                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này không?')"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger room-action-btn">
                            <i class="fa fa-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection

@push('styles')
<style>
    .room-detail-page {
        display: grid;
        gap: 22px;
    }

    .room-hero {
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

    .room-icon {
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

    .room-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .room-copy h1 {
        margin: 6px 0 8px;
        color: #fff;
        font-size: 2.35rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .room-copy p {
        margin: 0;
        color: #cbd5e1;
        font-size: 1.05rem;
    }

    .room-capacity-badge {
        min-width: 138px;
        padding: 16px;
        border: 1px solid rgba(250,204,21,.2);
        border-radius: 8px;
        background: rgba(250,204,21,.1);
        text-align: center;
    }

    .room-capacity-badge strong {
        display: block;
        color: #facc15;
        font-size: 2rem;
        line-height: 1;
    }

    .room-capacity-badge span {
        color: #e5e7eb;
        font-weight: 900;
    }

    .room-info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .room-info-card,
    .room-actions {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .room-info-card {
        display: flex;
        gap: 14px;
        min-height: 110px;
        padding: 18px;
        align-items: center;
    }

    .room-info-card > span {
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

    .room-info-card small {
        display: block;
        color: #94a3b8;
        font-size: .8rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .room-info-card strong {
        display: block;
        margin-top: 5px;
        color: #fff;
        font-size: 1.05rem;
        line-height: 1.35;
    }

    .room-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px;
    }

    .room-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
    }

    @media (max-width: 991.98px) {
        .room-hero,
        .room-info-grid {
            grid-template-columns: 1fr 1fr;
        }

        .room-capacity-badge {
            text-align: left;
        }
    }

    @media (max-width: 575.98px) {
        .room-hero,
        .room-info-grid {
            grid-template-columns: 1fr;
        }

        .room-hero {
            padding: 20px;
        }

        .room-copy h1 {
            font-size: 1.9rem;
        }

        .room-actions {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>
@endpush
