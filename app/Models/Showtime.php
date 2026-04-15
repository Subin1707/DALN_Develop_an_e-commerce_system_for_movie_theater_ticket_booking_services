<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'room_id',
        'start_time',
        'end_time',
        'price',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'price'      => 'integer',
    ];

    /* =========================
     |        RELATIONS
     |=========================*/

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /* =========================
     |          HELPERS
     |=========================*/

    public function getOccupiedSeatsAttribute(): array
    {
        return $this->bookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('seats')
            ->flatMap(fn ($seats) => explode(',', $seats))
            ->map(fn ($s) => trim($s))
            ->unique()
            ->values()
            ->toArray();
    }

    public function isSeatOccupied(string $seatCode): bool
    {
        return in_array($seatCode, $this->occupied_seats, true);
    }

    public function isEnded(): bool
    {
        return $this->end_time->isPast();
    }

    public function canBook(): bool
    {
        return now()->lt($this->start_time);
    }
}
