<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method bool isAdmin()
 * @method bool isStaff()
 * @method bool isUser()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /* ===================== FILLABLE ===================== */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin | staff | user
    ];

    /* ===================== HIDDEN ===================== */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* ===================== CASTS ===================== */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* ===================== ROLE CHECK ===================== */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'staff' => 'Nhân viên',
            default => 'Khách hàng',
        };
    }

    /* ===================== RELATIONSHIPS ===================== */

    // ✅ Booking của user (QUAN TRỌNG để mỗi user có danh sách riêng)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Ticket do user tạo
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    // Ticket user được phân xử lý (staff/admin)
    public function assignedTickets()
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to');
    }

    // Phản hồi support
    public function supportReplies()
    {
        return $this->hasMany(SupportReply::class);
    }
}
