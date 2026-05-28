@csrf

@php
    $selectedMovieId = old('movie_id', $showtime->movie_id ?? '');
    $selectedRoomId = old('room_id', $showtime->room_id ?? '');
    $selectedMovie = collect($movies)->firstWhere('id', (int) $selectedMovieId);
    $selectedRoom = collect($rooms)->firstWhere('id', (int) $selectedRoomId);
    $startValue = old('start_time', isset($showtime->start_time) ? date('Y-m-d\TH:i', strtotime($showtime->start_time)) : '');
    $priceValue = old('price', $showtime->price ?? '');
@endphp

@if ($errors->any())
    <div class="alert alert-danger showtime-alert">
        <strong>Vui lòng kiểm tra lại thông tin.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="showtime-form-layout">
    <div class="showtime-form-main">
        <div class="showtime-field">
            <label class="form-label" for="movie_id">Phim</label>
            <select id="movie_id" name="movie_id" class="form-select" required>
                <option value="">Chọn phim</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}" data-label="{{ $movie->title }}" {{ (string) $selectedMovieId === (string) $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeach
            </select>
            <small class="field-hint">Chọn đúng phim sẽ hiển thị trên vé và trang đặt vé.</small>
        </div>

        <div class="showtime-field">
            <label class="form-label" for="room_id">Phòng chiếu</label>
            <select id="room_id" name="room_id" class="form-select" required>
                <option value="">Chọn phòng chiếu</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" data-label="{{ $room->name }}" {{ (string) $selectedRoomId === (string) $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
            <small class="field-hint">Phòng chiếu quyết định sơ đồ ghế khách sẽ chọn.</small>
        </div>

        <div class="showtime-form-row">
            <div class="showtime-field">
                <label class="form-label" for="start_time">Thời gian chiếu</label>
                <input
                    id="start_time"
                    type="datetime-local"
                    name="start_time"
                    class="form-control"
                    value="{{ $startValue }}"
                    required
                >
            </div>

            <div class="showtime-field">
                <label class="form-label" for="price">Giá vé</label>
                <div class="input-group showtime-input-group">
                    <input
                        id="price"
                        type="number"
                        name="price"
                        class="form-control"
                        value="{{ $priceValue }}"
                        min="0"
                        step="1000"
                        required
                    >
                    <span class="input-group-text">VNĐ</span>
                </div>
            </div>
        </div>
    </div>

    <aside class="showtime-summary">
        <span class="summary-kicker">Tóm tắt</span>
        <h2 id="showtimeSummaryMovie">{{ $selectedMovie->title ?? 'Chưa chọn phim' }}</h2>

        <div class="summary-list">
            <div>
                <i class="fa fa-video-camera"></i>
                <span id="showtimeSummaryRoom">{{ $selectedRoom->name ?? 'Chưa chọn phòng' }}</span>
            </div>
            <div>
                <i class="fa fa-clock-o"></i>
                <span id="showtimeSummaryTime">{{ $startValue ? date('d/m/Y H:i', strtotime($startValue)) : 'Chưa chọn thời gian' }}</span>
            </div>
            <div>
                <i class="fa fa-ticket"></i>
                <span id="showtimeSummaryPrice">{{ $priceValue !== '' ? number_format((float) $priceValue, 0, ',', '.') . ' VNĐ' : 'Chưa nhập giá vé' }}</span>
            </div>
        </div>

        <p>Thông tin này sẽ được dùng khi khách đặt vé, thanh toán và xuất vé PDF.</p>
    </aside>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const movieInput = document.getElementById('movie_id');
        const roomInput = document.getElementById('room_id');
        const timeInput = document.getElementById('start_time');
        const priceInput = document.getElementById('price');

        const movieText = document.getElementById('showtimeSummaryMovie');
        const roomText = document.getElementById('showtimeSummaryRoom');
        const timeText = document.getElementById('showtimeSummaryTime');
        const priceText = document.getElementById('showtimeSummaryPrice');

        const selectedLabel = (select, fallback) => {
            const option = select.options[select.selectedIndex];
            return option && option.value ? option.dataset.label || option.textContent.trim() : fallback;
        };

        const formatTime = (value) => {
            if (!value) {
                return 'Chưa chọn thời gian';
            }

            const date = new Date(value);
            if (Number.isNaN(date.getTime())) {
                return 'Chưa chọn thời gian';
            }

            return date.toLocaleString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
            });
        };

        const formatPrice = (value) => {
            if (!value) {
                return 'Chưa nhập giá vé';
            }

            return new Intl.NumberFormat('vi-VN').format(Number(value)) + ' VNĐ';
        };

        const updateSummary = () => {
            movieText.textContent = selectedLabel(movieInput, 'Chưa chọn phim');
            roomText.textContent = selectedLabel(roomInput, 'Chưa chọn phòng');
            timeText.textContent = formatTime(timeInput.value);
            priceText.textContent = formatPrice(priceInput.value);
        };

        [movieInput, roomInput, timeInput, priceInput].forEach((input) => {
            input.addEventListener('input', updateSummary);
            input.addEventListener('change', updateSummary);
        });
    });
</script>

<div class="showtime-form-actions">
    <a href="{{ route('admin.showtimes.index') }}" class="btn btn-outline-light showtime-form-btn">
        <i class="fa fa-arrow-left"></i>
        Quay lại
    </a>
    <button type="submit" class="btn btn-success showtime-form-btn">
        <i class="fa fa-floppy-o"></i>
        {{ $submitLabel ?? 'Lưu suất chiếu' }}
    </button>
</div>
