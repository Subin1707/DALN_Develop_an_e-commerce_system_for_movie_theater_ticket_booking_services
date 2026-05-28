@extends('layouts.app')

@section('content')
<div class="support-page">
    <div class="support-hero">
        <div class="support-hero-copy">
            <span class="support-kicker">Trung tâm hỗ trợ</span>
            <h3>Hỗ trợ khách hàng</h3>
            <p>Theo dõi yêu cầu hỗ trợ, trao đổi với nhân viên và kiểm tra trạng thái xử lý tại một nơi.</p>
        </div>

        @if(auth()->user()->role === 'user')
            <a href="{{ route('support.create') }}" class="support-primary-btn">
                <i class="fa fa-plus"></i>
                Tạo ticket mới
            </a>
        @endif
    </div>

    <div class="support-stats">
        <div class="support-stat">
            <span><i class="fa fa-inbox"></i></span>
            <div>
                <strong>{{ $tickets->total() }}</strong>
                <small>Tổng ticket</small>
            </div>
        </div>
        <div class="support-stat">
            <span><i class="fa fa-clock-o"></i></span>
            <div>
                <strong>{{ $tickets->where('status', 'open')->count() + $tickets->where('status', 'processing')->count() }}</strong>
                <small>Đang xử lý</small>
            </div>
        </div>
        <div class="support-stat">
            <span><i class="fa fa-check"></i></span>
            <div>
                <strong>{{ $tickets->whereIn('status', ['answered', 'closed'])->count() }}</strong>
                <small>Đã phản hồi</small>
            </div>
        </div>
    </div>

    @if($tickets->isEmpty())
        <div class="support-empty">
            <div class="support-empty-icon">
                <i class="fa fa-comments-o"></i>
            </div>
            <h4>Chưa có ticket nào</h4>
            <p>Khi gặp vấn đề về đặt vé, thanh toán hoặc tài khoản, hãy tạo ticket để nhân viên hỗ trợ nhanh hơn.</p>

            @if(auth()->user()->role === 'user')
                <a href="{{ route('support.create') }}" class="support-primary-btn">
                    <i class="fa fa-plus"></i>
                    Tạo yêu cầu hỗ trợ
                </a>
            @endif
        </div>
    @else
        <div class="cinema-table-card support-table-card">
            <div class="table-responsive">
                <table class="table cinema-table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td><span class="table-code">#{{ $ticket->id }}</span></td>
                                <td>
                                    <div class="table-title">{{ $ticket->subject }}</div>
                                    @if($ticket->booking)
                                        <div class="table-muted">Booking #{{ $ticket->booking->id }}</div>
                                    @endif
                                </td>
                                <td><span class="cinema-badge neutral">{{ ucfirst($ticket->category) }}</span></td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'open' => 'warning',
                                            'processing' => 'info',
                                            'answered' => 'success',
                                            'closed' => 'neutral',
                                        ][$ticket->status] ?? 'neutral';
                                    @endphp
                                    <span class="cinema-badge {{ $statusClass }}">{{ strtoupper($ticket->status) }}</span>
                                </td>
                                <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('support.show', $ticket) }}" class="btn btn-sm btn-outline-primary cinema-action-btn">
                                        <i class="fa fa-comments"></i> Xem chat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .support-page {
        display: grid;
        gap: 22px;
    }

    .support-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 28px;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(233,69,96,.18), rgba(15,23,42,.96) 42%, rgba(17,24,39,.98)),
            radial-gradient(circle at top right, rgba(250,204,21,.12), transparent 34%);
        box-shadow: 0 22px 55px rgba(0,0,0,.26);
    }

    .support-kicker {
        color: #facc15;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .support-hero h3 {
        margin: 8px 0;
        color: #fff;
        font-size: 2rem;
        font-weight: 900;
    }

    .support-hero p {
        max-width: 640px;
        margin: 0;
        color: #cbd5e1;
        font-size: 1rem;
        line-height: 1.6;
    }

    .support-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 18px;
        border: 0;
        border-radius: 8px;
        background: #e94560;
        color: #fff;
        font-weight: 900;
        text-decoration: none;
        box-shadow: 0 12px 26px rgba(233,69,96,.28);
        white-space: nowrap;
    }

    .support-primary-btn:hover {
        background: #d6334d;
        color: #fff;
    }

    .support-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .support-stat {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 86px;
        padding: 18px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        background: #0f172a;
    }

    .support-stat span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 1.2rem;
    }

    .support-stat strong {
        display: block;
        color: #fff;
        font-size: 1.45rem;
        line-height: 1;
    }

    .support-stat small {
        color: #94a3b8;
        font-weight: 800;
    }

    .support-empty {
        min-height: 280px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 42px 20px;
        border: 1px dashed rgba(255,255,255,.16);
        border-radius: 8px;
        background: #0f172a;
        text-align: center;
        box-shadow: 0 18px 45px rgba(0,0,0,.22);
    }

    .support-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 74px;
        height: 74px;
        border-radius: 50%;
        background: rgba(233,69,96,.16);
        color: #fb7185;
        font-size: 2rem;
    }

    .support-empty h4 {
        margin: 6px 0 0;
        color: #fff;
        font-size: 1.45rem;
    }

    .support-empty p {
        max-width: 520px;
        margin: 0 0 8px;
        color: #94a3b8;
        font-size: 1rem;
        line-height: 1.6;
    }

    .support-table-card {
        margin-top: 0;
    }

    @media (max-width: 767.98px) {
        .support-hero {
            align-items: stretch;
            flex-direction: column;
            padding: 22px;
        }

        .support-primary-btn {
            width: 100%;
        }

        .support-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
