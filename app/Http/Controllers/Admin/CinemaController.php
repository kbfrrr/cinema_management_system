<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function index()
    {
        $cinemas = Cinema::withCount('halls')->latest('cinema_id')->paginate(10);
        return view('admin.cinemas.index', compact('cinemas'));
    }

    public function create()
    {
        return view('admin.cinemas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'location' => 'nullable|string|max:150',
        ]);

        Cinema::create($validated);

        return redirect()->route('admin.cinemas.index')
                         ->with('success', 'Cinema added successfully.');
    }

    public function edit(Cinema $cinema)
    {
        return view('admin.cinemas.edit', compact('cinema'));
    }

    public function update(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'location' => 'nullable|string|max:150',
        ]);

        $cinema->update($validated);

        return redirect()->route('admin.cinemas.index')
                         ->with('success', 'Cinema updated successfully.');
    }

    public function destroy(Cinema $cinema)
    {
        $cinema->delete();

        return redirect()->route('admin.cinemas.index')
                         ->with('success', 'Cinema deleted successfully.');
    }
}