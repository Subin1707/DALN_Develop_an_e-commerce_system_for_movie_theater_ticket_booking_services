@csrf

<div class="max-w-xl mx-auto backdrop-blur-xl bg-white/5
            border border-white/10 rounded-2xl shadow-2xl p-8 space-y-6">

    <h2 class="text-xl font-bold text-center mb-4">
        👤 Thông tin nhân viên
    </h2>

    <div>
        <label class="text-sm text-gray-300">Tên nhân viên</label>
        <input type="text" name="name"
               value="{{ old('name', $staff->name ?? '') }}"
               class="mt-1 w-full px-4 py-3 rounded-xl
                      bg-gray-900/70 border border-gray-700
                      focus:ring-2 focus:ring-blue-500 outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-300">Email</label>
        <input type="email" name="email"
               value="{{ old('email', $staff->email ?? '') }}"
               class="mt-1 w-full px-4 py-3 rounded-xl
                      bg-gray-900/70 border border-gray-700
                      focus:ring-2 focus:ring-blue-500 outline-none">
    </div>

    <div>
        <label class="text-sm text-gray-300">
            Mật khẩu {{ isset($staff) ? '(không đổi thì bỏ trống)' : '' }}
        </label>
        <input type="password" name="password"
               class="mt-1 w-full px-4 py-3 rounded-xl
                      bg-gray-900/70 border border-gray-700">
    </div>

    <div>
        <label class="text-sm text-gray-300">Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation"
               class="mt-1 w-full px-4 py-3 rounded-xl
                      bg-gray-900/70 border border-gray-700">
    </div>

    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('admin.staffs.index') }}"
           class="px-5 py-2 rounded-xl bg-gray-700 hover:bg-gray-600 transition">
            Huỷ
        </a>

        <button type="submit"
                class="px-6 py-2 rounded-xl font-semibold
                       bg-gradient-to-r from-green-500 to-emerald-600
                       hover:from-green-600 hover:to-emerald-700
                       shadow-lg transition">
            💾 Lưu
        </button>
    </div>
</div>
