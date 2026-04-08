<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $primaryKey = 'movie_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'release_date',
        'genre_id',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'genre_id');
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class, 'movie_id', 'movie_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'movie_id', 'movie_id');
    }
}