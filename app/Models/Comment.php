<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['movies_id', 'title', 'content', 'author_id'];
    public function movies() {
        return $this->belongsTo(Movie ::class, 'movies_id');
    }
    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    
    }
}