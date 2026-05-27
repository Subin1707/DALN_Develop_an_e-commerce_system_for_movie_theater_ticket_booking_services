@extends('layouts.app')

@section('content')

@php
    // ✅ $seats LÀ ARRAY
    $seatArray = $seats;
    $seatCount = count($seatArray);
    $totalPrice = $showtime->price * $seatCount;
@endphp

<div class="row trend_1 mb-4">
    <div class="col-md-12">
        <h4>
            <i class="fa fa-credit-card col_red me-1"></i>
            Xác nhận <span class="col_red">Thanh toán</span>
        </h4>

        {{-- ⏳ ĐẾM NGƯỢC GIỮ GHẾ --}}
        <div class="alert alert-danger py-2 mt-2" id="countdownBox">
            ⏳ Thời gian giữ ghế: <span id="countdown">60</span> giây
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">

        <h5 class="mb-3">🎬 Thông tin suất chiếu</h5>

        <ul class="list-group mb-3">
            <li class="list-group-item">
                <strong>Phim:</strong> {{ $showtime->movie->title }}
            </li>

            <li class="list-group-item">
                <strong>Ngày giờ:</strong>
                {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }}
            </li>

            <li class="list-group-item">
                <strong>Phòng:</strong> {{ $showtime->room->name }}
            </li>

            <li class="list-group-item">
                <strong>Ghế:</strong>
                {{ implode(', ', $seatArray) }}
            </li>

            <li class="list-group-item">
                <strong>Số vé:</strong> {{ $seatCount }}
            </li>

            <li class="list-group-item">
                <strong>Giá / vé:</strong>
                {{ number_format($showtime->price) }} ₫
            </li>
        </ul>

        <h4 class="text-end text-danger">
            💰 Tổng tiền: {{ number_format($totalPrice) }} ₫
        </h4>
    </div>
</div>

{{-- 🔥 FORM THANH TOÁN --}}
<form id="paymentForm" action="{{ route('bookings.store') }}" method="POST">
    @csrf

    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
    <input type="hidden" name="seats" value="{{ implode(',', $seatArray) }}">
    <input type="hidden" name="total_price" value="{{ $totalPrice }}">

    {{-- 💳 PHƯƠNG THỨC THANH TOÁN --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">💳 Phương thức thanh toán</h5>

            <div class="form-check mb-2">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       value="cash"
                       id="pay_cash"
                       checked>
                <label class="form-check-label" for="pay_cash">
                    💵 Thanh toán tiền mặt tại quầy
                </label>
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       value="transfer"
                       id="pay_transfer">
                <label class="form-check-label" for="pay_transfer">
                    🏦 Chuyển khoản / Ví điện tử
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       name="payment_method"
                       value="online"
                       id="pay_online">
                <label class="form-check-label" for="pay_online">
                    Thanh toan online
                </label>
            </div>

            <div id="onlinePaymentBox" class="alert alert-info mt-3 d-none">
                <strong>Thanh toan online:</strong>
                Quet ma QR ngan hang hoac vi dien tu, sau do bam nut xac nhan. Don demo se duoc xac nhan ngay.
                <div class="mt-2 small">
                    Noi dung chuyen khoan:
                    <strong>QHCINEMA-{{ $showtime->id }}-{{ implode('', $seatArray) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('bookings.create', $showtime->id) }}" class="btn btn-secondary">
            ← Quay lại chọn ghế
        </a>

        <button type="submit" class="btn btn-success" id="submitPaymentBtn">
            ✅ Xác nhận & Đặt vé
        </button>
    </div>
</form>

{{-- ================== SCRIPT ĐẾM NGƯỢC ================== --}}
<script>
    let timeLeft = 60;
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

    // Khi submit form thì dừng timer
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitPaymentBtn');
    const onlineBox = document.getElementById('onlinePaymentBox');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');

    paymentMethods.forEach((input) => {
        input.addEventListener('change', () => {
            if (onlineBox) {
                onlineBox.classList.toggle('d-none', input.value !== 'online' || !input.checked);
            }
        });
    });

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
                submitBtn.innerText = 'Dang xu ly...';
            }
        });
    }
</script>

@endsection
