<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $primaryKey = 'seat_id';
    public $timestamps = false;

    protected $fillable = [
        'hall_id',
        'seat_number',
        'row_number',
        'seat_type',
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'hall_id');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class, 'seat_id', 'seat_id');
    }
}