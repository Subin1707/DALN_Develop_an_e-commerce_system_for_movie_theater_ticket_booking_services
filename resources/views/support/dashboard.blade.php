@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h4 class="mb-0">
            <i class="fa fa-headphones col_red me-1"></i>
            Dashboard <span class="col_red">CSKH</span>
        </h4>

        <span class="cinema-badge info">Tổng: {{ $tickets->count() }} ticket</span>
    </div>

    <div class="cinema-table-card mb-4">
        <div class="p-3">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select bg-dark text-white border-secondary">
                        <option value="">-- Trạng thái --</option>
                        <option value="open" {{ request('status')=='open'?'selected':'' }}>Open</option>
                        <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Processing</option>
                        <option value="answered" {{ request('status')=='answered'?'selected':'' }}>Answered</option>
                        <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-select bg-dark text-white border-secondary">
                        <option value="">-- Danh mục --</option>
                        <option value="payment">Payment</option>
                        <option value="booking">Booking</option>
                        <option value="account">Account</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-outline-primary w-100">
                        <i class="fa fa-filter me-1"></i> Lọc
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="cinema-table-card">
        <div class="table-responsive">
            <table class="table cinema-table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Khách hàng</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Phụ trách</th>
                        <th>Ngày tạo</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td><span class="table-code">#{{ $ticket->id }}</span></td>
                            <td><div class="table-title">{{ $ticket->subject }}</div></td>
                            <td>{{ $ticket->user->name }}</td>
                            <td><span class="cinema-badge info">{{ strtoupper($ticket->category) }}</span></td>
                            <td>
                                @php
                                    $statusClass = match($ticket->status) {
                                        'open' => 'danger',
                                        'processing' => 'warning',
                                        'answered' => 'success',
                                        'closed' => 'neutral',
                                        default => 'neutral'
                                    };
                                @endphp

                                <span class="cinema-badge {{ $statusClass }}">{{ strtoupper($ticket->status) }}</span>
                            </td>
                            <td>
                                @if ($ticket->assignedStaff)
                                    {{ $ticket->assignedStaff->name }}
                                @else
                                    <span class="table-muted">Chưa gán</span>
                                @endif
                            </td>
                            <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('support.show', $ticket) }}" class="btn btn-sm btn-primary cinema-action-btn">
                                    <i class="fa fa-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="cinema-empty-row">Không có ticket nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
