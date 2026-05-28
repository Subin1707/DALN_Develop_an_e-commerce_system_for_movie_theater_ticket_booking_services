@php
    $movie ??= null;
    $posterPreview = $movie?->poster ? asset($movie->poster) : asset('img/default_movie.jpg');
@endphp

<div class="movie-form-layout">
    <section class="movie-form-main">
        <div class="movie-field">
            <label for="title" class="form-label">Tên phim</label>
            <input type="text"
                   name="title"
                   id="title"
                   class="form-control"
                   value="{{ old('title', $movie->title ?? '') }}"
                   placeholder="Nhập tên phim"
                   required>
        </div>

        <div class="movie-form-row">
            <div class="movie-field">
                <label for="genre" class="form-label">Thể loại</label>
                <input type="text"
                       name="genre"
                       id="genre"
                       class="form-control"
                       value="{{ old('genre', $movie->genre ?? '') }}"
                       placeholder="Ví dụ: Action, Drama">
            </div>

            <div class="movie-field">
                <label for="duration" class="form-label">Thời lượng</label>
                <div class="input-group movie-input-group">
                    <input type="number"
                           name="duration"
                           id="duration"
                           min="1"
                           class="form-control"
                           value="{{ old('duration', $movie->duration ?? '') }}"
                           placeholder="120"
                           required>
                    <span class="input-group-text">phút</span>
                </div>
            </div>
        </div>

        <div class="movie-field">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description"
                      id="description"
                      class="form-control"
                      rows="6"
                      placeholder="Nhập mô tả phim">{{ old('description', $movie->description ?? '') }}</textarea>
        </div>
    </section>

    <aside class="movie-form-side">
        <div class="poster-preview">
            <img src="{{ $posterPreview }}" alt="Poster hiện tại" id="posterPreview">
        </div>

        <div class="movie-field">
            <label for="poster" class="form-label">Poster</label>
            <input type="file"
                   name="poster"
                   id="poster"
                   class="form-control"
                   accept="image/*">
            <small class="field-hint">Chọn ảnh mới nếu muốn thay poster hiện tại.</small>
        </div>

        <div class="movie-field">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" {{ old('status', $movie->status ?? 'active') == 'active' ? 'selected' : '' }}>Đang chiếu</option>
                <option value="inactive" {{ old('status', $movie->status ?? '') == 'inactive' ? 'selected' : '' }}>Ngừng chiếu</option>
            </select>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    const posterInput = document.getElementById('poster');
    const posterPreview = document.getElementById('posterPreview');

    if (posterInput && posterPreview) {
        posterInput.addEventListener('change', () => {
            const file = posterInput.files && posterInput.files[0];

            if (!file) {
                return;
            }

            posterPreview.src = URL.createObjectURL(file);
        });
    }
</script>
@endpush
