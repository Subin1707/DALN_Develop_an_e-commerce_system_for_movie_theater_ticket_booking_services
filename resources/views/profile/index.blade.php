@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="blog_1r1 p-4 text-white rounded shadow-sm account-sidebar">
                <div class="text-center mb-4">
                    <div class="account-page-avatar mx-auto mb-3">
                        {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h4 class="mb-1">Quản lý <span class="col_red">Tài khoản</span></h4>
                    <p class="text-secondary mb-0">{{ Auth::user()->email }}</p>
                </div>

                <hr class="line mb-4">

                <h6 class="mb-3">
                    <a href="{{ route('profile.edit') }}" class="account-sidebar-link">
                        <i class="fa fa-pencil me-2"></i> Chỉnh sửa thông tin
                    </a>
                </h6>
                <h6 class="mb-3">
                    <a href="#" class="account-sidebar-link">
                        <i class="fa fa-heart me-2"></i> Danh sách yêu thích
                    </a>
                </h6>
                <h6 class="mb-4">
                    <a href="#" class="account-sidebar-link">
                        <i class="fa fa-history me-2"></i> Lịch sử xem
                    </a>
                </h6>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <button type="button"
                        class="btn btn-outline-danger w-100 account-logout-btn"
                        onclick="document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out me-2"></i> Đăng xuất
                </button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm account-info-card">
                <div class="card-header bg_red text-white">
                    <h5 class="mb-0"><i class="fa fa-user-circle me-2"></i>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Vai trò:</strong> {{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .account-sidebar,
    .account-info-card {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,.08);
    }

    .account-info-card {
        color: #e5e7eb;
    }

    .account-page-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 74px;
        height: 74px;
        border-radius: 50%;
        background: #facc15;
        color: #111827;
        font-size: 2rem;
        font-weight: 900;
        box-shadow: 0 10px 30px rgba(250,204,21,.18);
    }

    .account-sidebar-link {
        display: block;
        padding: 10px 12px;
        border-radius: 8px;
        color: #e5e7eb;
        text-decoration: none;
        background: rgba(255,255,255,.03);
    }

    .account-sidebar-link:hover {
        color: #fff;
        background: rgba(233,69,96,.16);
    }

    .account-logout-btn {
        border-radius: 8px;
        font-weight: 800;
    }
</style>
@endpush
