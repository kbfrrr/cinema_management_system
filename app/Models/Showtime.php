<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $primaryKey = 'showtime_id';
    public $timestamps = false;

    protected $fillable = [
        'movie_id',
        'hall_id',
        'start_time',
        'end_time',
        'price',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'hall_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'showtime_id', 'showtime_id');
    }
}