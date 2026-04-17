@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <h4 class="mb-4">
        🆘 Gửi yêu cầu hỗ trợ
    </h4>

    {{-- FORM --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('support.store') }}">
                @csrf

                {{-- TIÊU ĐỀ --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tiêu đề
                    </label>
                    <input
                        type="text"
                        name="subject"
                        class="form-control @error('subject') is-invalid @enderror"
                        placeholder="Ví dụ: Không thanh toán được vé"
                        value="{{ old('subject') }}"
                        required
                    >
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DANH MỤC --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Danh mục
                    </label>
                    <select
                        name="category"
                        class="form-select @error('category') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Chọn danh mục --</option>
                        <option value="payment" {{ old('category')=='payment'?'selected':'' }}>
                            Thanh toán
                        </option>
                        <option value="booking" {{ old('category')=='booking'?'selected':'' }}>
                            Đặt vé
                        </option>
                        <option value="account" {{ old('category')=='account'?'selected':'' }}>
                            Tài khoản
                        </option>
                        <option value="other" {{ old('category')=='other'?'selected':'' }}>
                            Khác
                        </option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BOOKING (OPTIONAL) --}}
                @if (isset($bookings) && $bookings->count())
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Booking liên quan (không bắt buộc)
                        </label>
                        <select name="booking_id" class="form-select">
                            <option value="">-- Không chọn --</option>
                            @foreach ($bookings as $booking)
                                <option
                                    value="{{ $booking->id }}"
                                    {{ old('booking_id')==$booking->id?'selected':'' }}
                                >
                                    #{{ $booking->id }} –
                                    {{ $booking->movie->title ?? 'Movie' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- NỘI DUNG --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nội dung chi tiết
                    </label>
                    <textarea
                        name="message"
                        rows="4"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Mô tả chi tiết vấn đề bạn gặp phải..."
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('support.index') }}" class="btn btn-outline-secondary">
                        ← Quay lại
                    </a>

                    <button class="btn btn-primary">
                        📩 Gửi yêu cầu
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
