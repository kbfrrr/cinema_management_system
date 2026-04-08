<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('genre')
                    ->whereHas('showtimes')
                    ->latest('movie_id')
                    ->paginate(12);

        $genres = Genre::orderBy('genre_name')->get();

        return view('customer.home', compact('movies', 'genres'));
    }

    public function filter()
    {
        $movies = Movie::with('genre')
                    ->when(request('genre_id'), fn($q) =>
                        $q->where('genre_id', request('genre_id')))
                    ->when(request('search'), fn($q) =>
                        $q->where('title', 'like', '%' . request('search') . '%'))
                    ->whereHas('showtimes')
                    ->latest('movie_id')
                    ->paginate(12)
                    ->withQueryString();

        $genres = Genre::orderBy('genre_name')->get();

        return view('customer.home', compact('movies', 'genres'));
    }
}