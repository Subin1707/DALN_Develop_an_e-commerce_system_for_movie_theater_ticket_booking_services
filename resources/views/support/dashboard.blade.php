@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            🎧 Dashboard CSKH
        </h4>

        <span class="badge bg-primary">
            Tổng: {{ $tickets->count() }} ticket
        </span>
    </div>

    {{-- FILTER --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2">

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Trạng thái --</option>
                        <option value="open" {{ request('status')=='open'?'selected':'' }}>Open</option>
                        <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Processing</option>
                        <option value="answered" {{ request('status')=='answered'?'selected':'' }}>Answered</option>
                        <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">-- Danh mục --</option>
                        <option value="payment">Payment</option>
                        <option value="booking">Booking</option>
                        <option value="account">Account</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-outline-primary w-100">
                        🔍 Lọc
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Khách hàng</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Assigned</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>

                        <td>
                            <strong>{{ $ticket->subject }}</strong>
                        </td>

                        <td>
                            {{ $ticket->user->name }}
                        </td>

                        <td>
                            <span class="badge bg-info">
                                {{ strtoupper($ticket->category) }}
                            </span>
                        </td>

                        <td>
                            @php
                                $color = match($ticket->status) {
                                    'open' => 'danger',
                                    'processing' => 'warning',
                                    'answered' => 'success',
                                    'closed' => 'secondary',
                                    default => 'light'
                                };
                            @endphp

                            <span class="badge bg-{{ $color }}">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </td>

                        <td>
                            @if ($ticket->assignedStaff)
                                {{ $ticket->assignedStaff->name }}
                            @else
                                <span class="text-muted">Chưa gán</span>
                            @endif
                        </td>

                        <td class="text-muted">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="text-center">
                            <a href="{{ route('support.show', $ticket) }}"
                               class="btn btn-sm btn-primary">
                                👁 Xem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Không có ticket nào
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
