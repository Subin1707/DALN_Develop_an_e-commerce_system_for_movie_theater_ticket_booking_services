@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">

        {{-- Sidebar trái --}}
        <div class="col-md-4">
            <div class="blog_1r1 p-4 bg-dark text-white rounded shadow-sm">
                <h4>Quản Lý <span class="col_red">Tài Khoản</span></h4>
                <hr class="line mb-4">

                <h6>
                    <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none">
                        <i class="fa fa-pencil me-2"></i> Chỉnh sửa thông tin
                    </a>
                </h6>
                <h6>
                    <a href="#" class="text-white text-decoration-none">
                        <i class="fa fa-heart me-2"></i> Danh sách yêu thích
                    </a>
                </h6>
                <h6>
                    <a href="#" class="text-white text-decoration-none">
                        <i class="fa fa-history me-2"></i> Lịch sử xem
                    </a>
                </h6>
                <h6>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-danger text-decoration-none">
                        <i class="fa fa-sign-out me-2"></i> Thoát
                    </a>
                </h6>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm" style="background: rgb(33 37 41)">
                <div class="card-header bg_red text-white">
                    <h5 class="mb-0"><i class="fa fa-user-circle me-2"></i>Thông tin tài khoản</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
