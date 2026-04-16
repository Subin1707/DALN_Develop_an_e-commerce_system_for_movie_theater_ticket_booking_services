<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép mass assignment
     */
    protected $fillable = [
        'user_id',
        'showtime_id',

        // vé
        'booking_code',
        'room_code',

        // ghế & giá
        'seats',
        'total_price',

        // thanh toán
        'payment_method',
        'status',

        // staff xác nhận
        'confirmed_at',
        'confirmed_by',

        // check-in QR
        'checked_in_at',
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected $casts = [
        'total_price'   => 'integer',
        'confirmed_at'  => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    /* =========================
     |        BOOT
     |=========================*/

    protected static function booted()
    {
        static::creating(function ($booking) {

            // ✅ Tự sinh mã vé (dùng cho QR)
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'TICKET-' . strtoupper(Str::random(8));
            }
        });
    }

    /* =========================
     |        RELATIONS
     |=========================*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /* =========================
     |        HELPERS
     |=========================*/

    /**
     * Danh sách ghế dạng array
     */
    public function getSeatArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->seats));
    }

    /**
     * Vé đã được check-in chưa
     */
    public function isCheckedIn(): bool
    {
        return !is_null($this->checked_in_at);
    }

    /**
     * Staff scan QR → check-in
     */
    public function checkIn(): void
    {
        if ($this->status !== 'confirmed') {
            abort(403, '❌ Vé chưa được xác nhận');
        }

        if ($this->isCheckedIn()) {
            abort(409, '❌ Vé này đã được sử dụng');
        }

        $this->update([
            'checked_in_at' => now(),
        ]);
    }

    /* =========================
     |           SCOPES
     |=========================*/

    /**
     * Tìm vé theo booking_code (QR)
     */
    public function scopeByBookingCode($query, string $code)
    {
        return $query->where('booking_code', $code);
    }
}
