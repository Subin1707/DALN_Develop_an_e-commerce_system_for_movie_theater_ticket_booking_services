@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')

<div class="container mx-auto py-10 text-gray-200">

    {{-- HEADER --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-yellow-400 mb-2">
            👤 Thông tin khách hàng
        </h1>
        <p class="text-gray-300">
            Chào mừng, <span class="font-semibold">{{ $user->name }}</span>!
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- PROFILE --}}
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">📄 Hồ sơ</h2>
            <p>Email: <strong>{{ $user->email }}</strong></p>
            <p>Vai trò: <strong>{{ $user->roleLabel() }}</strong></p>
        </div>

        {{-- CUSTOMER ACTIONS --}}
        <div class="bg-white/10 p-6 rounded-2xl shadow-md">
            <h2 class="text-xl font-semibold mb-2">🎫 Chức năng</h2>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('showtimes.index') }}" class="text-green-400 hover:underline">
                        ⏰ Xem lịch chiếu
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookings.choose') }}" class="text-green-400 hover:underline">
                        🛒 Đặt vé mới
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookings.history') }}" class="text-green-400 hover:underline">
                        🎟️ Vé của tôi ({{ $totalBooked }})
                    </a>
                </li>
            </ul>
        </div>

    </div>

    {{-- MY BOOKINGS --}}
    <div class="bg-white/10 p-6 rounded-2xl shadow-md">
        <h2 class="text-xl font-semibold mb-4">🎟️ Vé gần đây</h2>

        @if($bookings->isEmpty())
            <p class="text-gray-400">Bạn chưa đặt vé nào.</p>
        @else
            <ul class="space-y-3">
                @foreach($bookings as $booking)
                    <li class="border-b border-white/10 pb-2">
                        <strong>{{ $booking->showtime->movie->title }}</strong>
                        <br>
                        Ghế: {{ $booking->seats }} |
                        Trạng thái:
                        <span class="text-yellow-400">{{ strtoupper($booking->status) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>

@endsection
