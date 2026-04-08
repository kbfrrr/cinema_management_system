<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    public function show($id)
    {
        $movie = Movie::with([
                    'genre',
                    'reviews.user',
                    'showtimes' => fn($q) => $q
                        ->with('hall.cinema')
                        ->where('start_time', '>=', now())
                        ->orderBy('start_time'),
                ])->findOrFail($id);

        return view('customer.movie', compact('movie'));
    }
}