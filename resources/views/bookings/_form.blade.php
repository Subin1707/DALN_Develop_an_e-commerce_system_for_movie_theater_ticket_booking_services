<form action="{{ $action }}" method="POST">
    @csrf
    @if(!empty($method))
        @method($method)
    @endif

    {{-- SUẤT CHIẾU --}}
    <div class="mb-3">
        <label class="form-label">Suất chiếu</label>
        <select name="showtime_id" class="form-control" required>
            <option value="">-- Chọn suất chiếu --</option>
            @foreach($showtimes as $showtime)
                <option value="{{ $showtime->id }}"
                    @selected(old('showtime_id', $booking->showtime_id ?? '') == $showtime->id)>
                    {{ $showtime->movie->title ?? 'Phim không xác định' }}
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
               value="{{ old('seats', $booking->seats ?? '') }}"
               placeholder="VD: A1 hoặc A1,A2"
               required>
    </div>

    {{-- TỔNG TIỀN --}}
    <div class="mb-3">
        <label class="form-label">Tổng tiền (₫)</label>
        <input type="number"
               name="total_price"
               class="form-control"
               min="0"
               value="{{ old('total_price', $booking->total_price ?? 0) }}"
               required>
    </div>

    {{-- TRẠNG THÁI (CHỈ ADMIN) --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-control">
            <option value="pending"
                @selected(old('status', $booking->status ?? 'pending') == 'pending')>
                Chờ xử lý
            </option>
            <option value="confirmed"
                @selected(old('status', $booking->status ?? '') == 'confirmed')>
                Đã xác nhận
            </option>
            <option value="cancelled"
                @selected(old('status', $booking->status ?? '') == 'cancelled')>
                Đã hủy
            </option>
        </select>
    </div>
    @endif

    {{-- ACTION --}}
    <div class="d-flex justify-content-between">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Quay lại
        </a>

        <button type="submit" class="btn btn-success">
            💾 Lưu Booking
        </button>
    </div>
</form>
