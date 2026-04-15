<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_id',
        'name',
        'seat_rows',
        'seat_cols',
    ];

    protected $casts = [
        'seat_rows' => 'integer',
        'seat_cols' => 'integer',
    ];

    /* =========================
     |        RELATIONS
     |=========================*/

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    /* =========================
     |          HELPERS
     |=========================*/

    public function generateSeats(): array
    {
        $seats = [];

        for ($row = 0; $row < $this->seat_rows; $row++) {
            $rowChar = chr(65 + $row);
            for ($col = 1; $col <= $this->seat_cols; $col++) {
                $seats[] = $rowChar . $col;
            }
        }

        return $seats;
    }

    public function totalSeats(): int
    {
        return $this->seat_rows * $this->seat_cols;
    }
}
