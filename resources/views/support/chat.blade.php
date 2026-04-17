@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <h4 class="mb-3">
        💬 CSKH – Ticket #{{ $ticket->id }}
        <span class="badge bg-info">
            {{ strtoupper($ticket->status) }}
        </span>
    </h4>

    {{-- THÔNG TIN TICKET --}}
    <div class="card mb-3">
        <div class="card-body">
            <strong>{{ $ticket->subject }}</strong>
            <div class="text-muted small">
                {{ ucfirst($ticket->category) }} ·
                Tạo lúc {{ $ticket->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    {{-- CHAT --}}
    <div class="card shadow-sm">
        <div class="card-body" style="height:420px; overflow-y:auto">

            @forelse ($ticket->replies as $reply)

                @php
                    $isMine = auth()->id() === $reply->user_id;
                    $isStaff = $reply->user->role !== 'user';
                @endphp

                <div class="d-flex mb-3 {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                    <div style="max-width:70%">
                        <div class="small text-muted mb-1 {{ $isMine ? 'text-end' : '' }}">
                            {{ $reply->user->name }}

                            @if ($isStaff)
                                <span class="badge bg-secondary">
                                    {{ strtoupper($reply->user->role) }}
                                </span>
                            @endif
                        </div>

                        <div class="p-2 rounded
                            {{ $isMine ? 'bg-primary text-white' : 'bg-light border' }}">
                            {{ $reply->message }}
                        </div>

                        <div class="small text-muted mt-1 {{ $isMine ? 'text-end' : '' }}">
                            {{ $reply->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

            @empty
                <p class="text-muted text-center">
                    ⏳ Ticket đang chờ CSKH phản hồi
                </p>
            @endforelse

        </div>

        {{-- KIỂM SOÁT FLOW --}}
        @php
            $hasStaffReply = $ticket->replies
                ->filter(fn($r) => $r->user && $r->user->role !== 'user')
                ->count() > 0;
        @endphp

        {{-- INPUT --}}
        @if ($ticket->status === 'closed')
            <div class="card-footer text-center text-muted">
                🔒 Ticket đã đóng
            </div>

        @elseif (auth()->user()->role === 'user' && ! $hasStaffReply)
            <div class="card-footer text-center text-muted">
                ⏳ Vui lòng chờ CSKH phản hồi
            </div>

        @else
            <div class="card-footer">
                <form method="POST" action="{{ route('support.reply', $ticket) }}">
                    @csrf

                    <textarea
                        name="message"
                        class="form-control mb-2"
                        rows="2"
                        placeholder="Nhập tin nhắn..."
                        required
                    ></textarea>

                    <button class="btn btn-primary w-100">
                        📩 Gửi
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection
