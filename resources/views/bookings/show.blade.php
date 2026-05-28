@extends('layouts.app')

@section('content')
@php
    $paymentLabels = [
        'cash' => ['label' => 'Tiền mặt', 'class' => 'warning', 'icon' => 'fa-money'],
        'transfer' => ['label' => 'Chuyển khoản', 'class' => 'info', 'icon' => 'fa-bank'],
        'online' => ['label' => 'Online', 'class' => 'success', 'icon' => 'fa-credit-card'],
    ];

    $payment = $paymentLabels[$booking->payment_method] ?? ['label' => 'N/A', 'class' => 'neutral', 'icon' => 'fa-question-circle'];
    $canShowQr = $booking->status === 'confirmed'
        && !$booking->checked_in_at
        && now()->lt($booking->showtime->start_time);
@endphp

<div class="ticket-page-head mb-4">
    <div>
        <p class="ticket-eyebrow mb-2">Chi tiết vé</p>
        <h3 class="mb-0">
            <i class="fa fa-ticket col_red me-2"></i>
            Vé <span class="col_red">{{ $booking->booking_code }}</span>
        </h3>
    </div>

    @if($booking->status === 'confirmed')
        <span class="cinema-badge success"><i class="fa fa-check-circle"></i> Đã đặt chỗ</span>
    @elseif($booking->status === 'pending')
        <span class="cinema-badge warning"><i class="fa fa-clock-o"></i> Chờ xử lý</span>
    @else
        <span class="cinema-badge danger">{{ ucfirst($booking->status) }}</span>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="ticket-shell">
    <div class="ticket-main">
        <div class="ticket-main-head">
            <div>
                <span class="cinema-badge neutral">Mã vé</span>
                <h2>{{ $booking->booking_code }}</h2>
            </div>
            <span class="cinema-badge {{ $payment['class'] }}">
                <i class="fa {{ $payment['icon'] }}"></i> {{ $payment['label'] }}
            </span>
        </div>

        <div class="movie-strip">
            <div class="movie-icon">
                <i class="fa fa-film"></i>
            </div>
            <div>
                <div class="ticket-label">Phim</div>
                <div class="movie-title">{{ $booking->showtime->movie->title ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="ticket-info-grid">
            <div class="ticket-info-item">
                <span class="ticket-icon"><i class="fa fa-user"></i></span>
                <div>
                    <div class="ticket-label">Khách hàng</div>
                    <strong>{{ $booking->user->name ?? 'N/A' }}</strong>
                </div>
            </div>

            <div class="ticket-info-item">
                <span class="ticket-icon"><i class="fa fa-calendar"></i></span>
                <div>
                    <div class="ticket-label">Suất chiếu</div>
                    <strong>{{ $booking->showtime->start_time->format('d/m/Y H:i') }}</strong>
                </div>
            </div>

            <div class="ticket-info-item">
                <span class="ticket-icon"><i class="fa fa-building"></i></span>
                <div>
                    <div class="ticket-label">Phòng</div>
                    <strong>{{ $booking->showtime->room->name ?? 'N/A' }}</strong>
                </div>
            </div>

            <div class="ticket-info-item">
                <span class="ticket-icon"><i class="fa fa-th"></i></span>
                <div>
                    <div class="ticket-label">Ghế</div>
                    <strong>{{ $booking->seats }}</strong>
                </div>
            </div>
        </div>

        <div class="ticket-total">
            <span>Tổng tiền</span>
            <strong>{{ number_format($booking->total_price) }} đ</strong>
        </div>
    </div>

    <aside class="ticket-qr-panel">
        <div class="qr-card">
            @if($canShowQr)
                <div class="qr-title">
                    <i class="fa fa-qrcode"></i>
                    <span>Mã QR Check-in</span>
                </div>

                <div class="qr-box">
                    {!! QrCode::size(220)->generate(route('staff.bookings.scan', $booking->booking_code)) !!}
                </div>

                <p>Xuất trình mã QR này cho nhân viên trước giờ chiếu.</p>
            @elseif($booking->checked_in_at)
                <div class="qr-closed">
                    <i class="fa fa-check-circle"></i>
                    <h5>Vé đã check-in</h5>
                    <p>Thời gian: {{ $booking->checked_in_at->format('d/m/Y H:i') }}</p>
                </div>
            @else
                <div class="qr-closed">
                    <i class="fa fa-lock"></i>
                    <h5>QR check-in đã đóng</h5>
                    <p>Suất chiếu đã bắt đầu hoặc vé chưa được xác nhận.</p>
                </div>
            @endif
        </div>
    </aside>
</div>

<div class="ticket-action-bar mt-4">
    <div class="cinema-actions">
        @if(Auth::id() === $booking->user_id)
            @if($booking->payment_method === 'online' && $booking->status === 'pending')
                <a href="{{ route('bookings.online.retry', $booking->id) }}" class="btn btn-success cinema-action-btn">
                    <i class="fa fa-credit-card"></i> Thanh toán online
                </a>
            @endif

            @if($booking->payment_method === 'transfer' && $booking->status === 'pending')
                <a href="{{ route('bookings.transfer.demo', $booking->id) }}" class="btn btn-success cinema-action-btn">
                    <i class="fa fa-bank"></i> Xác nhận chuyển khoản
                </a>
            @endif

            <a href="{{ route('bookings.pdf', $booking->id) }}" class="btn btn-danger cinema-action-btn">
                <i class="fa fa-file-pdf-o"></i> Xuất vé PDF
            </a>
        @endif

        @if(Auth::user()->role === 'staff' && $booking->status === 'pending')
            <form action="{{ route('staff.bookings.confirm', $booking->id) }}" method="POST">
                @csrf
                <button class="btn btn-success cinema-action-btn">
                    <i class="fa fa-check"></i> Xác nhận thanh toán
                </button>
            </form>
        @endif

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning cinema-action-btn">
                <i class="fa fa-pencil"></i> Chỉnh sửa
            </a>
        @endif
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary cinema-action-btn">
        <i class="fa fa-arrow-left"></i> Quay lại
    </a>
</div>
@endsection

@push('styles')
<style>
    .ticket-page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .ticket-eyebrow {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .ticket-shell {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 22px;
        align-items: stretch;
    }

    .ticket-main,
    .ticket-qr-panel,
    .ticket-action-bar {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 22px 55px rgba(0,0,0,.28);
    }

    .ticket-main {
        position: relative;
        overflow: hidden;
        padding: 28px;
    }

    .ticket-main::before,
    .ticket-main::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #010102;
        transform: translateY(-50%);
    }

    .ticket-main::before {
        left: -15px;
    }

    .ticket-main::after {
        right: -15px;
    }

    .ticket-main-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding-bottom: 22px;
        border-bottom: 1px dashed rgba(255,255,255,.18);
    }

    .ticket-main-head h2 {
        margin: 12px 0 0;
        color: #fff;
        font-size: 2rem;
        letter-spacing: .5px;
    }

    .movie-strip {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 24px 0;
        padding: 18px;
        border-radius: 8px;
        background: linear-gradient(90deg, rgba(233,69,96,.18), rgba(250,204,21,.08));
    }

    .movie-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        flex: 0 0 54px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 1.45rem;
    }

    .ticket-label {
        color: #94a3b8;
        font-size: .8rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .movie-title {
        color: #fff;
        font-size: 1.55rem;
        font-weight: 900;
        line-height: 1.15;
    }

    .ticket-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .ticket-info-item {
        display: flex;
        gap: 12px;
        min-height: 82px;
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .ticket-info-item strong {
        color: #fff;
        font-size: 1.08rem;
    }

    .ticket-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #f87171;
    }

    .ticket-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 22px;
        padding: 18px;
        border-radius: 8px;
        background: #111827;
        border: 1px solid rgba(250,204,21,.18);
    }

    .ticket-total span {
        color: #cbd5e1;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .ticket-total strong {
        color: #facc15;
        font-size: 1.65rem;
    }

    .ticket-qr-panel {
        padding: 18px;
    }

    .qr-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 14px;
        padding: 22px;
        border-radius: 8px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.025));
    }

    .qr-title {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        font-weight: 900;
        font-size: 1.08rem;
    }

    .qr-title i {
        color: #facc15;
    }

    .qr-box {
        padding: 14px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 16px 32px rgba(0,0,0,.28);
    }

    .qr-card p {
        max-width: 240px;
        margin: 0;
        color: #94a3b8;
        font-size: .95rem;
    }

    .qr-closed i {
        color: #facc15;
        font-size: 2.5rem;
        margin-bottom: 12px;
    }

    .qr-closed h5 {
        color: #fff;
    }

    .ticket-action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px;
    }

    @media (max-width: 991.98px) {
        .ticket-shell {
            grid-template-columns: 1fr;
        }

        .ticket-page-head,
        .ticket-action-bar {
            align-items: stretch;
            flex-direction: column;
        }
    }

    @media (max-width: 575.98px) {
        .ticket-main {
            padding: 20px;
        }

        .ticket-main-head {
            flex-direction: column;
        }

        .ticket-info-grid {
            grid-template-columns: 1fr;
        }

        .movie-title {
            font-size: 1.25rem;
        }
    }
</style>
@endpush
