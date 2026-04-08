<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $primaryKey = 'genre_id';
    public $timestamps = false;

    protected $fillable = ['genre_name'];

    public function movies()
    {
        return $this->hasMany(Movie::class, 'genre_id', 'genre_id');
    }
}