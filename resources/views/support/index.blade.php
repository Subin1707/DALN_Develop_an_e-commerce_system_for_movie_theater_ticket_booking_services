@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">📩 Hỗ trợ khách hàng</h4>

    {{-- USER tạo ticket --}}
    @if(auth()->user()->role === 'user')
        <a href="{{ route('support.create') }}" class="btn btn-primary mb-3">
            ➕ Tạo ticket mới
        </a>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>

                <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td class="fw-semibold">#{{ $ticket->id }}</td>

                        <td>
                            <div class="fw-semibold">
                                {{ $ticket->subject }}
                            </div>

                            @if($ticket->booking)
                                <small class="text-muted">
                                    🎟 Booking #{{ $ticket->booking->id }}
                                </small>
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-light text-dark">
                                {{ ucfirst($ticket->category) }}
                            </span>
                        </td>

                        <td>
                            @php
                                $colors = [
                                    'open' => 'warning',
                                    'processing' => 'primary',
                                    'answered' => 'success',
                                    'closed' => 'secondary',
                                ];
                            @endphp

                            <span class="badge bg-{{ $colors[$ticket->status] ?? 'secondary' }}">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </td>

                        <td class="text-muted">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="text-end">
                            <a href="{{ route('support.show', $ticket) }}"
                               class="btn btn-sm btn-outline-primary">
                                💬 Xem chat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            📭 Chưa có ticket nào
                        </td>
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
