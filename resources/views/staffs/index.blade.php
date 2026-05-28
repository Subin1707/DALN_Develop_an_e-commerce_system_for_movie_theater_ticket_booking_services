@extends('layouts.app')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="staff-index-page">
    <section class="staff-index-hero">
        <div>
            <span class="staff-index-kicker">Quản trị tài khoản</span>
            <h3>Quản lý nhân viên</h3>
            <p>Theo dõi và quản lý các tài khoản nhân viên dùng để xác nhận vé, check-in và hỗ trợ khách hàng.</p>
        </div>

        <a href="{{ route('admin.staffs.create') }}" class="staff-add-btn">
            <i class="fa fa-plus"></i>
            Thêm nhân viên
        </a>
    </section>

    <section class="staff-summary-grid">
        <div class="staff-summary-card">
            <span><i class="fa fa-users"></i></span>
            <div>
                <small>Tổng nhân viên</small>
                <strong>{{ $staffs->count() }}</strong>
            </div>
        </div>

        <div class="staff-summary-card">
            <span><i class="fa fa-shield"></i></span>
            <div>
                <small>Vai trò</small>
                <strong>Staff</strong>
            </div>
        </div>
    </section>

    <div class="cinema-table-card">
        <div class="cinema-table-toolbar">
            <h5>Danh sách nhân viên</h5>
            <span class="cinema-badge neutral">{{ $staffs->count() }} tài khoản</span>
        </div>

        <div class="table-responsive">
            <table class="table cinema-table align-middle staff-table">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($staffs as $staff)
                        <tr>
                            <td>
                                <div class="staff-name-cell">
                                    <span class="staff-avatar">{{ strtoupper(mb_substr($staff->name, 0, 1)) }}</span>
                                    <div>
                                        <div class="table-title">{{ $staff->name }}</div>
                                        <div class="table-muted">ID #{{ $staff->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $staff->email }}</td>
                            <td><span class="cinema-badge info">Nhân viên</span></td>
                            <td class="text-end">
                                <div class="cinema-actions justify-content-end">
                                    <a href="{{ route('admin.staffs.edit', $staff) }}" class="btn btn-sm btn-outline-primary cinema-action-btn">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>

                                    <form action="{{ route('admin.staffs.destroy', $staff) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Xoá nhân viên?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger cinema-action-btn">
                                            <i class="fa fa-trash"></i> Xoá
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="cinema-empty-row">Chưa có nhân viên nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .staff-index-page {
        display: grid;
        gap: 22px;
    }

    .staff-index-hero,
    .staff-summary-card {
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background: #0f172a;
        box-shadow: 0 18px 45px rgba(0,0,0,.24);
    }

    .staff-index-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 28px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.16), rgba(15,23,42,.98) 45%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
    }

    .staff-index-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .staff-index-hero h3 {
        margin: 7px 0;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .staff-index-hero p {
        max-width: 720px;
        margin: 0;
        color: #cbd5e1;
        line-height: 1.6;
    }

    .staff-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-weight: 900;
        text-decoration: none;
        box-shadow: 0 12px 26px rgba(233,69,96,.28);
        white-space: nowrap;
    }

    .staff-add-btn:hover {
        background: #d6334d;
        color: #fff;
    }

    .staff-summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .staff-summary-card {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 96px;
        padding: 18px;
    }

    .staff-summary-card span,
    .staff-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .staff-summary-card span {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 1.25rem;
    }

    .staff-summary-card small {
        display: block;
        color: #94a3b8;
        font-size: .82rem;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .staff-summary-card strong {
        display: block;
        margin-top: 5px;
        color: #fff;
        font-size: 1.35rem;
    }

    .staff-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .staff-avatar {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        border-radius: 50%;
        background: #facc15;
        color: #111827;
        font-weight: 900;
    }

    @media (max-width: 767.98px) {
        .staff-index-hero {
            align-items: stretch;
            flex-direction: column;
        }

        .staff-add-btn {
            width: 100%;
        }

        .staff-summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
