<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    protected $primaryKey = 'cinema_id';
    public $timestamps = false;

    protected $fillable = ['name', 'location'];

    public function halls()
    {
        return $this->hasMany(Hall::class, 'cinema_id', 'cinema_id');
    }
}