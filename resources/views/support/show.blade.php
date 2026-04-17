@extends('layouts.app')

@section('content')
<div class="container">

    {{-- TIÊU ĐỀ --}}
    <h4 class="mb-3">
        💬 CSKH – Ticket #{{ $ticket->id }}
        <span class="badge bg-info">
            {{ strtoupper($ticket->status) }}
        </span>
    </h4>

    {{-- THÔNG TIN TICKET --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <p class="mb-1"><strong>Tiêu đề:</strong> {{ $ticket->subject }}</p>
            <p class="mb-1"><strong>Danh mục:</strong> {{ ucfirst($ticket->category) }}</p>

            @if ($ticket->booking)
                <p class="mb-1">
                    <strong>Booking liên quan:</strong>
                    <a href="{{ route('bookings.show', $ticket->booking) }}">
                        #{{ $ticket->booking->id }}
                    </a>
                </p>
            @endif

            <p class="text-muted mb-0">
                Tạo lúc: {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    {{-- CHAT --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            💬 Hội thoại
        </div>

        <div class="card-body" style="height: 400px; overflow-y: auto">
            @forelse ($ticket->replies as $reply)
                <div class="mb-3">
                    <strong>
                        {{ $reply->user->name }}

                        @if ($reply->user->role !== 'user')
                            <span class="badge bg-secondary ms-1">
                                {{ strtoupper($reply->user->role) }}
                            </span>
                        @else
                            <span class="badge bg-primary ms-1">Khách hàng</span>
                        @endif
                    </strong>

                    <div class="mt-1">{{ $reply->message }}</div>

                    <div class="text-muted small">
                        {{ $reply->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <hr>
            @empty
                <p class="text-muted text-center mb-0">
                    Chưa có phản hồi nào từ CSKH.
                </p>
            @endforelse
        </div>

        {{-- FORM --}}
        @php
            $user = auth()->user();
            $hasStaffReply = $ticket->replies->contains(
                fn($r) => $r->user && in_array($r->user->role, ['staff', 'admin'])
            );

            // route theo role
            $replyRoute = match($user->role) {
                'staff' => route('staff.support.reply.store', $ticket),
                'admin' => route('admin.support.reply.store', $ticket),
                default => route('support.reply.store', $ticket),
            };
        @endphp

        @if ($ticket->status === 'closed')
            <div class="card-footer text-center text-muted">
                🔒 Ticket đã đóng
            </div>

        {{-- USER: chưa có staff reply thì chờ --}}
        @elseif ($user->role === 'user' && ! $hasStaffReply)
            <div class="card-footer text-center text-muted">
                ⏳ Vui lòng chờ nhân viên CSKH phản hồi
            </div>

        {{-- STAFF / ADMIN / USER đã được trả lời --}}
        @else
            <div class="card-footer">
                <form method="POST" action="{{ $replyRoute }}">
                    @csrf
                    <textarea
                        name="message"
                        class="form-control mb-2"
                        rows="2"
                        placeholder="Nhập phản hồi..."
                        required
                    ></textarea>

                    <button type="submit" class="btn btn-primary px-4">
                        📩 Gửi phản hồi
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
