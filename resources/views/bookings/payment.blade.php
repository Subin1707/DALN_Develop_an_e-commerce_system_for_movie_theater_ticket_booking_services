@extends('layouts.app')

@section('content')
@php
    $seatArray = $seats;
    $seatCount = count($seatArray);
    $totalPrice = $showtime->price * $seatCount;
@endphp

<div class="payment-page">
    <div class="payment-head">
        <div>
            <span class="payment-kicker">Bước cuối</span>
            <h3>
                <i class="fa fa-credit-card col_red me-2"></i>
                Xác nhận <span class="col_red">Thanh toán</span>
            </h3>
        </div>

        <div class="seat-hold-timer" id="countdownBox">
            <i class="fa fa-hourglass-half"></i>
            <div>
                <span>Thời gian giữ ghế</span>
                <strong><span id="countdown">300</span> giây</strong>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="paymentForm" action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
        <input type="hidden" name="seats" value="{{ implode(',', $seatArray) }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

        <div class="payment-layout">
            <section class="payment-summary">
                <div class="summary-header">
                    <span class="summary-icon"><i class="fa fa-film"></i></span>
                    <div>
                        <span class="payment-kicker">Thông tin suất chiếu</span>
                        <h4>{{ $showtime->movie->title }}</h4>
                    </div>
                </div>

                <div class="summary-grid">
                    <div class="summary-item">
                        <span>Ngày giờ</span>
                        <strong>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="summary-item">
                        <span>Phòng</span>
                        <strong>{{ $showtime->room->name }}</strong>
                    </div>
                    <div class="summary-item">
                        <span>Ghế</span>
                        <strong>{{ implode(', ', $seatArray) }}</strong>
                    </div>
                    <div class="summary-item">
                        <span>Số vé</span>
                        <strong>{{ $seatCount }}</strong>
                    </div>
                    <div class="summary-item">
                        <span>Giá / vé</span>
                        <strong>{{ number_format($showtime->price) }} đ</strong>
                    </div>
                    <div class="summary-item">
                        <span>Mã phòng</span>
                        <strong>{{ $showtime->room->code ?? $showtime->room->name }}</strong>
                    </div>
                </div>

                <div class="payment-total">
                    <span>Tổng tiền</span>
                    <strong>{{ number_format($totalPrice) }} đ</strong>
                </div>
            </section>

            <section class="payment-methods">
                <div class="section-title">
                    <span class="payment-kicker">Chọn phương thức</span>
                    <h4>Phương thức thanh toán</h4>
                </div>

                <div class="method-options">
                    <label class="method-card active" for="pay_cash">
                        <input type="radio" name="payment_method" value="cash" id="pay_cash" checked>
                        <span class="method-icon"><i class="fa fa-money"></i></span>
                        <span class="method-copy">
                            <strong>Tiền mặt tại quầy</strong>
                            <small>Đặt vé chờ nhân viên xác nhận thanh toán.</small>
                        </span>
                    </label>

                    <label class="method-card" for="pay_transfer">
                        <input type="radio" name="payment_method" value="transfer" id="pay_transfer">
                        <span class="method-icon"><i class="fa fa-bank"></i></span>
                        <span class="method-copy">
                            <strong>Chuyển khoản</strong>
                            <small>Mở màn hình demo chuyển khoản và xác nhận giao dịch.</small>
                        </span>
                    </label>

                    <label class="method-card" for="pay_online">
                        <input type="radio" name="payment_method" value="online" id="pay_online">
                        <span class="method-icon"><i class="fa fa-mobile"></i></span>
                        <span class="method-copy">
                            <strong>MoMo online</strong>
                            <small>Mô phỏng luồng MoMo UAT với ký HMAC, return và IPN.</small>
                        </span>
                    </label>
                </div>

                <div id="onlinePaymentBox" class="payment-note info d-none">
                    <strong>Thanh toán online:</strong>
                    Hệ thống sẽ chuyển sang cổng MoMo UAT mô phỏng. Vé chỉ được xác nhận sau khi giao dịch trả về thành công.
                </div>

                <div id="transferPaymentBox" class="payment-note warning d-none">
                    <strong>Chuyển khoản:</strong>
                    Hệ thống sẽ tạo vé chờ thanh toán và mở màn hình demo thông tin chuyển khoản. Vé chỉ hoàn tất sau khi xác nhận giao dịch thành công.
                </div>
            </section>
        </div>

        <div class="payment-action-bar">
            <a href="{{ route('bookings.create', $showtime->id) }}" class="btn btn-secondary payment-action-btn">
                <i class="fa fa-arrow-left"></i> Quay lại chọn ghế
            </a>

            <button type="submit" class="btn btn-success payment-action-btn" id="submitPaymentBtn">
                <i class="fa fa-check"></i> Xác nhận & Đặt vé
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .payment-page {
        display: grid;
        gap: 22px;
    }

    .payment-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 24px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 32%);
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .payment-kicker {
        color: #facc15;
        font-size: .76rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .payment-head h3 {
        margin: 6px 0 0;
        color: #fff;
        font-size: 1.9rem;
        font-weight: 900;
    }

    .seat-hold-timer {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        min-width: 230px;
        padding: 12px 14px;
        border: 1px solid rgba(250,204,21,.24);
        border-radius: 8px;
        background: rgba(250,204,21,.1);
        color: #fff;
    }

    .seat-hold-timer i {
        color: #facc15;
        font-size: 1.3rem;
    }

    .seat-hold-timer span {
        display: block;
        color: #cbd5e1;
        font-size: .84rem;
        font-weight: 800;
    }

    .seat-hold-timer strong {
        color: #facc15;
        font-size: 1.2rem;
    }

    .payment-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 430px;
        gap: 22px;
    }

    .payment-summary,
    .payment-methods,
    .payment-action-bar {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .payment-summary,
    .payment-methods {
        padding: 22px;
    }

    .summary-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 18px;
        border-bottom: 1px dashed rgba(255,255,255,.14);
    }

    .summary-icon,
    .method-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 1.25rem;
    }

    .summary-header h4,
    .section-title h4 {
        margin: 5px 0 0;
        color: #fff;
        font-size: 1.45rem;
        font-weight: 900;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .summary-item {
        min-height: 76px;
        padding: 14px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
    }

    .summary-item span {
        display: block;
        color: #94a3b8;
        font-size: .82rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .summary-item strong {
        display: block;
        margin-top: 7px;
        color: #fff;
        font-size: 1.05rem;
    }

    .payment-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 18px;
        padding: 18px;
        border-radius: 8px;
        background: #111827;
        border: 1px solid rgba(250,204,21,.18);
    }

    .payment-total span {
        color: #cbd5e1;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .payment-total strong {
        color: #facc15;
        font-size: 1.65rem;
    }

    .method-options {
        display: grid;
        gap: 12px;
        margin-top: 18px;
    }

    .method-card {
        display: flex;
        align-items: center;
        gap: 13px;
        margin: 0;
        padding: 14px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: rgba(255,255,255,.035);
        cursor: pointer;
        transition: border-color .18s ease, background .18s ease, transform .18s ease;
    }

    .method-card:hover,
    .method-card.active {
        border-color: rgba(233,69,96,.78);
        background: rgba(233,69,96,.12);
    }

    .method-card input {
        width: 18px;
        height: 18px;
        accent-color: #e94560;
    }

    .method-copy {
        display: grid;
        gap: 4px;
    }

    .method-copy strong {
        color: #fff;
        font-size: 1rem;
    }

    .method-copy small {
        color: #94a3b8;
        line-height: 1.35;
    }

    .payment-note {
        margin-top: 14px;
        padding: 13px 14px;
        border-radius: 8px;
        color: #dbeafe;
        line-height: 1.5;
    }

    .payment-note.info {
        border: 1px solid rgba(56,189,248,.28);
        background: rgba(56,189,248,.1);
    }

    .payment-note.warning {
        border: 1px solid rgba(250,204,21,.26);
        background: rgba(250,204,21,.1);
        color: #fde68a;
    }

    .payment-action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 22px;
        padding: 16px;
    }

    .payment-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border-radius: 8px;
        font-weight: 900;
    }

    @media (max-width: 991.98px) {
        .payment-head,
        .payment-action-bar {
            align-items: stretch;
            flex-direction: column;
        }

        .payment-layout {
            grid-template-columns: 1fr;
        }

        .seat-hold-timer {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .payment-head,
        .payment-summary,
        .payment-methods {
            padding: 18px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let timeLeft = 300;
    const countdownEl = document.getElementById('countdown');

    const timer = setInterval(() => {
        timeLeft--;

        if (countdownEl) {
            countdownEl.innerText = timeLeft;
        }

        if (timeLeft <= 0) {
            clearInterval(timer);
            alert('Hết thời gian giữ ghế! Vui lòng chọn lại.');
            window.location.href = "{{ route('bookings.create', $showtime->id) }}";
        }
    }, 1000);

    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitPaymentBtn');
    const onlineBox = document.getElementById('onlinePaymentBox');
    const transferBox = document.getElementById('transferPaymentBox');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const methodCards = document.querySelectorAll('.method-card');

    function syncPaymentUi() {
        paymentMethods.forEach((input) => {
            const card = input.closest('.method-card');
            const isActive = input.checked;

            if (card) {
                card.classList.toggle('active', isActive);
            }

            if (onlineBox && input.value === 'online') {
                onlineBox.classList.toggle('d-none', !isActive);
            }

            if (transferBox && input.value === 'transfer') {
                transferBox.classList.toggle('d-none', !isActive);
            }
        });
    }

    methodCards.forEach((card) => {
        card.addEventListener('click', () => {
            const input = card.querySelector('input[name="payment_method"]');
            if (input) {
                input.checked = true;
                syncPaymentUi();
            }
        });
    });

    paymentMethods.forEach((input) => {
        input.addEventListener('change', syncPaymentUi);
    });

    syncPaymentUi();

    if (form) {
        let submitted = false;

        form.addEventListener('submit', (event) => {
            if (submitted) {
                event.preventDefault();
                return;
            }

            submitted = true;
            clearInterval(timer);

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
            }
        });
    }
</script>
@endpush
