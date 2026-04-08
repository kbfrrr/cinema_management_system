<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    public function index()
    {
        $showtimes = Showtime::with(['movie', 'hall.cinema'])
                        ->orderBy('start_time', 'desc')
                        ->paginate(10);
        return view('admin.showtimes.index', compact('showtimes'));
    }

    public function create()
    {
        $movies = Movie::orderBy('title')->get();
        $halls  = Hall::with('cinema')->orderBy('hall_id')->get();
        return view('admin.showtimes.create', compact('movies', 'halls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'hall_id'    => 'required|exists:halls,hall_id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'price'      => 'required|numeric|min:0',
        ]);

        Showtime::create($validated);

        return redirect()->route('admin.showtimes.index')
                         ->with('success', 'Showtime added successfully.');
    }

    public function edit(Showtime $showtime)
    {
        $movies = Movie::orderBy('title')->get();
        $halls  = Hall::with('cinema')->orderBy('hall_id')->get();
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'halls'));
    }

    public function update(Request $request, Showtime $showtime)
    {
        $validated = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'hall_id'    => 'required|exists:halls,hall_id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'price'      => 'required|numeric|min:0',
        ]);

        $showtime->update($validated);

        return redirect()->route('admin.showtimes.index')
                         ->with('success', 'Showtime updated successfully.');
    }

    public function destroy(Showtime $showtime)
    {
        $showtime->delete();

        return redirect()->route('admin.showtimes.index')
                         ->with('success', 'Showtime deleted successfully.');
    }
}