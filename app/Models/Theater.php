<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'total_rooms', // ✅ Thêm dòng này để cho phép lưu tổng số phòng
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
