@extends('layouts.app')

@section('content')

<h1 class="mb-4">✏️ Sửa Booking #{{ $booking->id }}</h1>

<form method="POST"
      action="{{ Auth::user()->role === 'admin'
            ? route('admin.bookings.update', $booking)
            : route('staff.bookings.update', $booking) }}">
    @csrf
    @method('PUT')

```
{{-- SUẤT CHIẾU --}}
<div class="mb-3">
    <label class="form-label">Suất chiếu</label>
    <select name="showtime_id" class="form-control" required>
        @foreach($showtimes as $showtime)
            <option value="{{ $showtime->id }}"
                {{ $showtime->id == $booking->showtime_id ? 'selected' : '' }}>
                {{ $showtime->movie->title ?? 'N/A' }}
                ({{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y H:i') }})
            </option>
        @endforeach
    </select>
</div>

{{-- GHẾ --}}
<div class="mb-3">
    <label class="form-label">Ghế</label>
    <input type="text"
           name="seats"
           class="form-control"
           value="{{ $booking->seats }}"
           required>
</div>

{{-- TỔNG TIỀN --}}
<div class="mb-3">
    <label class="form-label">Tổng tiền</label>
    <input type="number"
           name="total_price"
           class="form-control"
           value="{{ $booking->total_price }}"
           min="0"
           required>
</div>

{{-- PHƯƠNG THỨC THANH TOÁN --}}
<div class="mb-3">
    <label class="form-label">Phương thức thanh toán</label>
    <select name="payment_method" class="form-control">
        <option value="">-- Chưa chọn --</option>
        <option value="cash" {{ $booking->payment_method === 'cash' ? 'selected' : '' }}>
            💵 Tiền mặt
        </option>
        <option value="transfer" {{ $booking->payment_method === 'transfer' ? 'selected' : '' }}>
            🏦 Chuyển khoản
        </option>
        <option value="online" {{ $booking->payment_method === 'online' ? 'selected' : '' }}>
            Online
        </option>
    </select>
</div>

{{-- TRẠNG THÁI --}}
<div class="mb-3">
    <label class="form-label">Trạng thái</label>
    <select name="status" class="form-control" required>
        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
            Pending
        </option>
        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
            Confirmed
        </option>
        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
            Cancelled
        </option>
    </select>
</div>

<button type="submit" class="btn btn-success">
    ✅ Cập nhật
</button>
```

</form>

@endsection
