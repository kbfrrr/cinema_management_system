<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $primaryKey = 'hall_id';
    public $timestamps = false;

    protected $fillable = ['cinema_id', 'hall_name', 'capacity'];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id', 'cinema_id');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'hall_id', 'hall_id');
    }
}