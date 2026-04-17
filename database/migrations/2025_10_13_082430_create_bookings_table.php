<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            /* ================= USER & SHOWTIME ================= */
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('showtime_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /* ================= VÉ ================= */
            // Mã vé – dùng để tạo QR & scan
            $table->string('booking_code')->unique();

            // Snapshot phòng lúc đặt
            $table->string('room_code')->nullable();

            /* ================= GHẾ & GIÁ ================= */
            // Ví dụ: A1,A2,A3
            $table->string('seats');

            $table->unsignedInteger('total_price');

            /* ================= THANH TOÁN ================= */
            $table->enum('payment_method', ['cash', 'transfer'])
                  ->nullable();

            /* ================= TRẠNG THÁI ================= */
            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled'
            ])->default('pending');

            /* ================= CHECK-IN ================= */
            // Đã scan QR chưa
            $table->timestamp('checked_in_at')->nullable();

            /* ================= STAFF ================= */
            $table->timestamp('confirmed_at')->nullable();

            $table->foreignId('confirmed_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            /* ================= INDEX ================= */
            $table->index(['showtime_id', 'status']);
            $table->index('booking_code');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
