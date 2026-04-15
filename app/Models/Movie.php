<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration',
        'poster',
        'release_date',
        'status',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'movies_id');
    }
}
