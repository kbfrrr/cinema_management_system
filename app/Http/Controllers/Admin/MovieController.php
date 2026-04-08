<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('genre')->latest('movie_id')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $genres = Genre::orderBy('genre_name')->get();
        return view('admin.movies.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:150',
            'description'  => 'nullable|string',
            'duration'     => 'required|integer|min:1',
            'release_date' => 'nullable|date',
            'genre_id'     => 'nullable|exists:genres,genre_id',
        ]);

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
                         ->with('success', 'Movie added successfully.');
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::orderBy('genre_name')->get();
        return view('admin.movies.edit', compact('movie', 'genres'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:150',
            'description'  => 'nullable|string',
            'duration'     => 'required|integer|min:1',
            'release_date' => 'nullable|date',
            'genre_id'     => 'nullable|exists:genres,genre_id',
        ]);

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
                         ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('admin.movies.index')
                         ->with('success', 'Movie deleted successfully.');
    }
}