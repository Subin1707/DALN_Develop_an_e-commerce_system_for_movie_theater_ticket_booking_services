@csrf
<div class="mb-3">
    <label class="form-label">Tên rạp</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $theater->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Địa chỉ</label>
    <input type="text" name="address" class="form-control"
           value="{{ old('address', $theater->address ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Tổng số phòng</label>
    <input type="number" name="total_rooms" class="form-control"
           value="{{ old('total_rooms', $theater->total_rooms ?? '') }}">
</div>

<button type="submit" class="btn btn-success">💾 Lưu</button>
