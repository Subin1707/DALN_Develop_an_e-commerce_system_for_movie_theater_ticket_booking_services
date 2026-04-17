<div class="mb-3">
    <label for="title" class="form-label">Tên phim</label>
    <input type="text" name="title" id="title" class="form-control"
           value="{{ old('title', $movie->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="genre" class="form-label">Thể loại</label>
    <input type="text" name="genre" id="genre" class="form-control"
           value="{{ old('genre', $movie->genre ?? '') }}">
</div>

<div class="mb-3">
    <label for="duration" class="form-label">Thời lượng (phút)</label>
    <input type="number" name="duration" id="duration" min="1"
           class="form-control" value="{{ old('duration', $movie->duration ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Mô tả</label>
    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $movie->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="poster" class="form-label">Poster</label>
    <input type="file" name="poster" id="poster" class="form-control">
    @if(isset($movie) && $movie->poster)
        <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" width="120" class="mt-2">
    @endif
</div>

<div class="mb-3">
    <label for="status" class="form-label">Trạng thái</label>
    <select name="status" id="status" class="form-select" required>
        <option value="active" {{ old('status', $movie->status ?? '') == 'active' ? 'selected' : '' }}>Đang chiếu</option>
        <option value="inactive" {{ old('status', $movie->status ?? '') == 'inactive' ? 'selected' : '' }}>Ngưng chiếu</option>
    </select>
</div>
