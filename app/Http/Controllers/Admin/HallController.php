<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index(Cinema $cinema)
    {
        $halls = $cinema->halls()->latest('hall_id')->paginate(10);
        return view('admin.halls.index', compact('cinema', 'halls'));
    }

    public function create(Cinema $cinema)
    {
        return view('admin.halls.create', compact('cinema'));
    }

    public function store(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            'hall_name' => 'required|string|max:50',
            'capacity'  => 'required|integer|min:1',
        ]);

        $cinema->halls()->create($validated);

        return redirect()->route('admin.cinemas.halls.index', $cinema->cinema_id)
                         ->with('success', 'Hall added successfully.');
    }

    public function edit(Cinema $cinema, Hall $hall)
    {
        return view('admin.halls.edit', compact('cinema', 'hall'));
    }

    public function update(Request $request, Cinema $cinema, Hall $hall)
    {
        $validated = $request->validate([
            'hall_name' => 'required|string|max:50',
            'capacity'  => 'required|integer|min:1',
        ]);

        $hall->update($validated);

        return redirect()->route('admin.cinemas.halls.index', $cinema->cinema_id)
                         ->with('success', 'Hall updated successfully.');
    }

    public function destroy(Cinema $cinema, Hall $hall)
    {
        $hall->delete();

        return redirect()->route('admin.cinemas.halls.index', $cinema->cinema_id)
                         ->with('success', 'Hall deleted successfully.');
    }
}