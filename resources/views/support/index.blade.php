@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h4 class="mb-0">
            <i class="fa fa-envelope col_red me-1"></i>
            Hỗ trợ <span class="col_red">Khách hàng</span>
        </h4>

        @if(auth()->user()->role === 'user')
            <a href="{{ route('support.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Tạo ticket mới
            </a>
        @endif
    </div>

    <div class="cinema-table-card">
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
                    @forelse($tickets as $ticket)
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
                    @empty
                        <tr>
                            <td colspan="6" class="cinema-empty-row">Chưa có ticket nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
