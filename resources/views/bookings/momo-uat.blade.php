@extends('layouts.app')

@section('content')

@php
    $momoPayload = implode('|', [
        'partnerCode:' . $payment['partnerCode'],
        'requestId:' . $payment['requestId'],
        'orderId:' . $payment['orderId'],
        'amount:' . $payment['amount'],
        'signature:' . substr($payment['signature'], 0, 16),
    ]);
    $momoQr = QrCode::size(220)->margin(1)->generate($momoPayload);
@endphp

<div class="container py-4">
    <div class="mx-auto" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-1">MoMo UAT Simulator</h3>
                <div class="text-muted">requestId {{ $payment['requestId'] }}</div>
            </div>
            <span class="badge bg-warning text-dark px-3 py-2" id="momoStatus">Cho thanh toan</span>
        </div>

        <div class="row g-3">
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="mb-3">Quet QR MoMo</h5>
                        <div class="bg-white d-inline-block p-3 border rounded">
                            {!! $momoQr !!}
                        </div>
                        <div class="small text-muted mt-3">
                            QR demo chua ket noi app MoMo that, nhung du lieu gom orderId, amount va signature rut gon.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Partner</span>
                                <strong>{{ $payment['partnerCode'] }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Order ID</span>
                                <strong>{{ $payment['orderId'] }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>So tien</span>
                                <strong class="text-danger">{{ number_format((int) $payment['amount']) }} VND</strong>
                            </li>
                            <li class="list-group-item">
                                <div class="text-muted">Noi dung</div>
                                <strong>{{ $payment['orderInfo'] }}</strong>
                            </li>
                        </ul>

                        <div class="alert alert-info">
                            Simulator se tao payload MoMo return/IPN co resultCode, transId, responseTime va signature HMAC-SHA256.
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary" type="button" id="simulateMomoBtn">
                                Mo phong thanh toan tren app MoMo
                            </button>

                            <form action="{{ route('momo.uat.complete') }}" method="POST" id="momoSuccessForm">
                                @csrf
                                <input type="hidden" name="requestId" value="{{ $payment['requestId'] }}">
                                <input type="hidden" name="result" value="success">
                                <button type="submit" class="btn btn-success" id="momoSuccessBtn" disabled>
                                    Hoan tat thanh toan
                                </button>
                            </form>

                            <form action="{{ route('momo.uat.complete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="requestId" value="{{ $payment['requestId'] }}">
                                <input type="hidden" name="result" value="failed">
                                <button type="submit" class="btn btn-outline-danger">
                                    Giao dich that bai
                                </button>
                            </form>
                        </div>

                        <div class="alert alert-success mt-3 d-none" id="momoApprovedBox">
                            MoMo UAT da chap nhan giao dich. San sang return/IPN ve he thong.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const simulateMomoBtn = document.getElementById('simulateMomoBtn');
const momoSuccessBtn = document.getElementById('momoSuccessBtn');
const momoApprovedBox = document.getElementById('momoApprovedBox');
const momoStatus = document.getElementById('momoStatus');

if (simulateMomoBtn) {
    simulateMomoBtn.addEventListener('click', () => {
        simulateMomoBtn.disabled = true;
        simulateMomoBtn.innerText = 'Dang xu ly tren MoMo...';
        if (momoStatus) {
            momoStatus.className = 'badge bg-info text-dark px-3 py-2';
            momoStatus.innerText = 'Dang xu ly';
        }

        setTimeout(() => {
            momoApprovedBox.classList.remove('d-none');
            momoSuccessBtn.disabled = false;
            simulateMomoBtn.innerText = 'MoMo da xac thuc';
            if (momoStatus) {
                momoStatus.className = 'badge bg-success px-3 py-2';
                momoStatus.innerText = 'Da xac thuc';
            }
        }, 1400);
    });
}
</script>

@endsection
