@extends('layouts.app')

@section('content')

@php
    $bankPayload = implode('|', [
        'BANK:QH Cinema Demo Bank',
        'ACC:123456789',
        'NAME:QH CINEMA',
        'AMOUNT:' . (int) $booking->total_price,
        'REF:' . $booking->booking_code,
    ]);
    $bankQr = QrCode::size(220)->margin(1)->generate($bankPayload);
@endphp

<div class="container py-4">
    <div class="mx-auto" style="max-width: 960px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-1">Thanh toan chuyen khoan</h3>
                <div class="text-muted">Ma giao dich {{ $booking->booking_code }}</div>
            </div>
            <span class="badge bg-warning text-dark px-3 py-2">Dang cho thanh toan</span>
        </div>

        <div class="alert alert-warning">
            Ve dang duoc giu ghe. He thong chi xac nhan ve sau khi nhan du tien va dung noi dung chuyen khoan.
            <strong>Thoi gian con lai:</strong> <span id="transferCountdown">300</span> giay
        </div>

        <div class="row g-3">
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="mb-3">Quet QR ngan hang</h5>
                        <div class="bg-white d-inline-block p-3 border rounded">
                            {!! $bankQr !!}
                        </div>
                        <div class="small text-muted mt-3">
                            QR demo chua ket noi ngan hang that, nhung payload gom du tai khoan, so tien va ma tham chieu.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="mb-3">Thong tin chuyen khoan</h5>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Ngan hang</span>
                                <strong>QH Cinema Demo Bank</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>So tai khoan</span>
                                <strong>123456789</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Chu tai khoan</span>
                                <strong>QH CINEMA</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>So tien</span>
                                <strong class="text-danger">{{ number_format($booking->total_price) }} VND</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Noi dung bat buoc</span>
                                <strong>{{ $booking->booking_code }}</strong>
                            </li>
                        </ul>

                        <h6>Thong tin ve</h6>
                        <div class="small text-muted mb-3">
                            {{ $booking->showtime->movie->title ?? 'N/A' }} -
                            {{ $booking->showtime->room->name ?? $booking->room_code }} -
                            ghe {{ $booking->seats }}
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-secondary" id="checkTransferBtn">
                                Kiem tra giao dich
                            </button>

                            <form action="{{ route('bookings.transfer.complete', $booking) }}" method="POST" id="successForm">
                                @csrf
                                <input type="hidden" name="result" value="success">
                                <input type="hidden" name="bank_reference" id="bankReference">
                                <button type="submit" class="btn btn-success" id="confirmTransferBtn" disabled>
                                    Xac nhan da nhan tien
                                </button>
                            </form>

                            <form action="{{ route('bookings.transfer.complete', $booking) }}" method="POST">
                                @csrf
                                <input type="hidden" name="result" value="failed">
                                <button type="submit" class="btn btn-outline-danger">
                                    Huy thanh toan
                                </button>
                            </form>
                        </div>

                        <div class="alert alert-info mt-3 d-none" id="bankWebhookBox">
                            Ngan hang demo da gui webhook thanh cong.
                            Ma doi soat: <strong id="bankReferenceText"></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let secondsLeft = 300;
const countdown = document.getElementById('transferCountdown');
const checkBtn = document.getElementById('checkTransferBtn');
const confirmBtn = document.getElementById('confirmTransferBtn');
const webhookBox = document.getElementById('bankWebhookBox');
const bankReference = document.getElementById('bankReference');
const bankReferenceText = document.getElementById('bankReferenceText');

const timer = setInterval(() => {
    secondsLeft--;
    if (countdown) countdown.innerText = secondsLeft;
    if (secondsLeft <= 0) {
        clearInterval(timer);
        if (checkBtn) checkBtn.disabled = true;
        if (confirmBtn) confirmBtn.disabled = true;
    }
}, 1000);

if (checkBtn) {
    checkBtn.addEventListener('click', () => {
        checkBtn.disabled = true;
        checkBtn.innerText = 'Dang doi ngan hang...';

        setTimeout(() => {
            const ref = 'BANK-' + Date.now();
            bankReference.value = ref;
            bankReferenceText.innerText = ref;
            webhookBox.classList.remove('d-none');
            confirmBtn.disabled = false;
            checkBtn.innerText = 'Da tim thay giao dich';
        }, 1200);
    });
}
</script>

@endsection
