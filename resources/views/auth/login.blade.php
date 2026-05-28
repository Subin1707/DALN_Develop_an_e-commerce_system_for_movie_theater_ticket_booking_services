@extends('layouts.app')

@section('title', 'Đăng nhập - Q&HCinema')

@section('content')
<section class="auth-shell py-4 py-lg-5">
    <div class="row justify-content-center align-items-stretch g-0 auth-panel mx-auto">
        <div class="col-lg-5 auth-brand-pane d-none d-lg-flex flex-column justify-content-between">
            <a href="{{ route('home') }}" class="auth-logo text-white text-decoration-none">
                <i class="fa fa-video-camera"></i>
                <span>Q&HCINEMA</span>
            </a>

            <div>
                <span class="auth-kicker">Rạp chiếu phim online</span>
                <h1>Đặt vé nhanh, quản lý vé gọn, check-in bằng QR.</h1>
                <p>Đăng nhập để tiếp tục chọn ghế, thanh toán và xem lại lịch sử đặt vé của bạn.</p>
            </div>

            <div class="auth-feature-list">
                <div><i class="fa fa-check-circle"></i> Giữ ghế khi thanh toán</div>
                <div><i class="fa fa-qrcode"></i> Vé PDF có mã QR</div>
                <div><i class="fa fa-credit-card"></i> Hỗ trợ thanh toán online demo</div>
            </div>
        </div>

        <div class="col-lg-7 auth-form-pane">
            <div class="auth-form-card">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                    <div>
                        <p class="auth-eyebrow mb-2">Chào mừng trở lại</p>
                        <h2 class="mb-1">Đăng nhập</h2>
                        <p class="text-secondary mb-0">Nhập tài khoản để tiếp tục đặt vé.</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm auth-home-link">
                        <i class="fa fa-home me-1"></i> Trang chủ
                    </a>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group auth-input-group">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="admin@qhcinema.com"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="input-group auth-input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Nhập mật khẩu"
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="btn auth-password-toggle" data-target="password" aria-label="Hiện hoặc ẩn mật khẩu">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="auth-text-link" href="{{ route('password.request') }}">
                                Quên mật khẩu?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn auth-primary-btn w-100">
                        <i class="fa fa-sign-in me-2"></i> Đăng nhập
                    </button>

                    <div class="auth-switch mt-4">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .auth-shell {
        min-height: calc(100vh - 220px);
        display: flex;
        align-items: center;
    }

    .auth-panel {
        width: min(100%, 980px);
        background: #111827;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 24px 70px rgba(0,0,0,.38);
    }

    .auth-brand-pane {
        min-height: 620px;
        padding: 34px;
        background:
            linear-gradient(160deg, rgba(233,69,96,.96), rgba(26,26,46,.94)),
            url("{{ asset('img/dark_knight.jpg') }}") center/cover;
    }

    .auth-logo {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 800;
        letter-spacing: .5px;
        font-size: 1.2rem;
    }

    .auth-logo i {
        font-size: 1.55rem;
    }

    .auth-kicker,
    .auth-eyebrow {
        color: #facc15;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        font-size: .78rem;
    }

    .auth-brand-pane h1 {
        font-size: 2.55rem;
        line-height: 1.08;
        max-width: 390px;
        margin: 16px 0;
    }

    .auth-brand-pane p {
        max-width: 390px;
        color: rgba(255,255,255,.78);
        font-size: 1.03rem;
    }

    .auth-feature-list {
        display: grid;
        gap: 10px;
        color: rgba(255,255,255,.88);
    }

    .auth-feature-list i {
        color: #facc15;
        margin-right: 8px;
    }

    .auth-form-pane {
        background: #0f172a;
        display: flex;
        align-items: center;
        padding: 42px;
    }

    .auth-form-card {
        width: 100%;
        max-width: 460px;
        margin: 0 auto;
    }

    .auth-form-card h2 {
        color: #fff;
        font-weight: 800;
    }

    .auth-home-link {
        border-color: rgba(255,255,255,.18);
        color: #e5e7eb;
        white-space: nowrap;
    }

    .auth-form .form-label {
        color: #e5e7eb;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .auth-input-group {
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 8px;
        overflow: hidden;
        background: #111827;
    }

    .auth-input-group .input-group-text,
    .auth-input-group .form-control,
    .auth-password-toggle {
        border: 0;
        background: transparent;
        color: #f8fafc;
    }

    .auth-input-group .input-group-text {
        color: #e94560;
        width: 46px;
        justify-content: center;
    }

    .auth-input-group .form-control {
        min-height: 50px;
    }

    .auth-input-group .form-control:focus {
        box-shadow: none;
        background: transparent;
        color: #fff;
    }

    .auth-input-group:focus-within {
        border-color: #e94560;
        box-shadow: 0 0 0 .2rem rgba(233,69,96,.12);
    }

    .auth-password-toggle {
        width: 46px;
    }

    .auth-form .form-check-label {
        color: #cbd5e1;
    }

    .auth-form .form-check-input {
        background-color: #111827;
        border-color: rgba(255,255,255,.26);
    }

    .auth-form .form-check-input:checked {
        background-color: #e94560;
        border-color: #e94560;
    }

    .auth-text-link,
    .auth-switch a {
        color: #facc15;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-text-link:hover,
    .auth-switch a:hover {
        color: #fff;
    }

    .auth-primary-btn {
        min-height: 50px;
        border: 0;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-weight: 800;
    }

    .auth-primary-btn:hover {
        background: #d6334d;
        color: #fff;
    }

    .auth-switch {
        color: #cbd5e1;
        text-align: center;
    }

    @media (max-width: 991.98px) {
        .auth-form-pane {
            padding: 28px 18px;
        }

        .auth-panel {
            border-radius: 8px;
        }
    }

    @media (max-width: 575.98px) {
        .auth-form-card .d-flex.justify-content-between {
            flex-direction: column;
        }

        .auth-home-link {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.auth-password-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.target);
            const icon = button.querySelector('i');

            if (!input) {
                return;
            }

            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });
</script>
@endpush
