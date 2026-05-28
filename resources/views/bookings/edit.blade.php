@extends('layouts.app')

@section('content')
@php
    $isAdmin = Auth::user()->role === 'admin';
    $updateRoute = $isAdmin
        ? route('admin.bookings.update', $booking)
        : route('staff.bookings.update', $booking);
    $backRoute = $isAdmin
        ? route('admin.bookings.show', $booking)
        : route('staff.bookings.show', $booking);
@endphp

<div class="booking-edit-page">
    <section class="booking-edit-hero">
        <div class="booking-edit-icon">
            <i class="fa fa-pencil"></i>
        </div>
        <div>
            <span class="booking-edit-kicker">Quản lý booking</span>
            <h1>Sửa booking</h1>
            <p>{{ $booking->booking_code }} - {{ $booking->user->name ?? 'N/A' }}</p>
        </div>
    </section>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $updateRoute }}" class="booking-edit-panel">
        @csrf
        @method('PUT')

        <div class="booking-edit-grid">
            <div class="booking-field booking-field-wide">
                <label class="form-label">Suất chiếu</label>
                <select name="showtime_id" class="form-select" required>
                    @foreach($showtimes as $showtime)
                        <option value="{{ $showtime->id }}"
                            {{ (int) old('showtime_id', $booking->showtime_id) === (int) $showtime->id ? 'selected' : '' }}>
                            {{ $showtime->movie->title ?? 'N/A' }}
                            - {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}
                            - {{ $showtime->room->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="booking-field">
                <label class="form-label">Ghế</label>
                <input type="text"
                       name="seats"
                       class="form-control"
                       value="{{ old('seats', $booking->seats) }}"
                       placeholder="Ví dụ: C5,C6,C7"
                       required>
            </div>

            <div class="booking-field">
                <label class="form-label">Tổng tiền</label>
                <input type="number"
                       name="total_price"
                       class="form-control"
                       value="{{ old('total_price', $booking->total_price) }}"
                       min="0"
                       required>
            </div>

            <div class="booking-field">
                <label class="form-label">Phương thức thanh toán</label>
                <select name="payment_method" class="form-select" required>
                    <option value="cash" {{ old('payment_method', $booking->payment_method) === 'cash' ? 'selected' : '' }}>
                        Tiền mặt
                    </option>
                    <option value="transfer" {{ old('payment_method', $booking->payment_method) === 'transfer' ? 'selected' : '' }}>
                        Chuyển khoản
                    </option>
                    <option value="online" {{ old('payment_method', $booking->payment_method) === 'online' ? 'selected' : '' }}>
                        Online
                    </option>
                </select>
            </div>

            <div class="booking-field">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ old('status', $booking->status) === 'pending' ? 'selected' : '' }}>
                        Chờ xử lý
                    </option>
                    <option value="confirmed" {{ old('status', $booking->status) === 'confirmed' ? 'selected' : '' }}>
                        Đã xác nhận
                    </option>
                    <option value="cancelled" {{ old('status', $booking->status) === 'cancelled' ? 'selected' : '' }}>
                        Đã hủy
                    </option>
                </select>
            </div>
        </div>

        <div class="booking-edit-actions">
            <a href="{{ $backRoute }}" class="btn btn-secondary booking-edit-btn">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>

            <button type="submit" class="btn btn-primary booking-edit-btn">
                <i class="fa fa-save"></i> Cập nhật booking
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .booking-edit-page {
        display: grid;
        gap: 22px;
    }

    .booking-edit-hero,
    .booking-edit-panel {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .booking-edit-hero {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 26px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
    }

    .booking-edit-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 68px;
        height: 68px;
        flex: 0 0 68px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-size: 1.8rem;
        box-shadow: 0 14px 30px rgba(233,69,96,.3);
    }

    .booking-edit-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .booking-edit-hero h1 {
        margin: 6px 0 6px;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .booking-edit-hero p {
        margin: 0;
        color: #cbd5e1;
    }

    .booking-edit-panel {
        padding: 24px;
    }

    .booking-edit-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .booking-field-wide {
        grid-column: 1 / -1;
    }

    .booking-field {
        padding: 16px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .booking-field .form-label {
        color: #e5e7eb;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .booking-field .form-control,
    .booking-field .form-select {
        min-height: 46px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        background-color: #111827;
        color: #fff;
    }

    .booking-field .form-control:focus,
    .booking-field .form-select:focus {
        border-color: #e94560;
        box-shadow: 0 0 0 .18rem rgba(233,69,96,.12);
        background-color: #111827;
        color: #fff;
    }

    .booking-edit-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .booking-edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
        padding-inline: 18px;
    }

    @media (max-width: 767.98px) {
        .booking-edit-hero,
        .booking-edit-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .booking-edit-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
