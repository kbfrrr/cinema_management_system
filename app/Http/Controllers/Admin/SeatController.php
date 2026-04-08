<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(Hall $hall)
    {
        $seats = $hall->seats()->orderBy('row_number')->orderBy('seat_number')->paginate(50);
        return view('admin.seats.index', compact('hall', 'seats'));
    }

    public function create(Hall $hall)
    {
        return view('admin.seats.create', compact('hall'));
    }

    public function store(Request $request, Hall $hall)
    {
        $request->validate([
            'generate'  => 'nullable|in:yes',
            'rows'      => 'required_if:generate,yes|nullable|string|max:50',
            'seats_per_row' => 'required_if:generate,yes|nullable|integer|min:1|max:50',
            'seat_type' => 'required|in:standard,vip,wheelchair',
            // manual single seat
            'seat_number' => 'required_if:generate,|nullable|string|max:10',
            'row_number'  => 'required_if:generate,|nullable|string|max:5',
        ]);

        if ($request->generate === 'yes') {
            // Bulk generate seats
            $rows          = array_map('trim', explode(',', strtoupper($request->rows)));
            $seatsPerRow   = (int) $request->seats_per_row;
            $type          = $request->seat_type;
            $created       = 0;

            foreach ($rows as $row) {
                for ($i = 1; $i <= $seatsPerRow; $i++) {
                    $seatNumber = $row . $i;
                    // Skip if already exists
                    $exists = Seat::where('hall_id', $hall->hall_id)
                                  ->where('seat_number', $seatNumber)
                                  ->exists();
                    if (! $exists) {
                        Seat::create([
                            'hall_id'     => $hall->hall_id,
                            'seat_number' => $seatNumber,
                            'row_number'  => $row,
                            'seat_type'   => $type,
                        ]);
                        $created++;
                    }
                }
            }

            return redirect()->route('admin.halls.seats.index', $hall->hall_id)
                 ->with('success', "$created seats generated successfully.");
        }

        // Single seat
        Seat::create([
            'hall_id'     => $hall->hall_id,
            'seat_number' => strtoupper($request->seat_number),
            'row_number'  => strtoupper($request->row_number),
            'seat_type'   => $request->seat_type,
        ]);

        return redirect()->route('admin.halls.seats.index', $hall->hall_id)
                 ->with('success', 'Seat added successfully.');

    }

    public function edit(Seat $seat)
    {
        return view('admin.seats.edit', compact('seat'));
    }

    public function update(Request $request, Seat $seat)
    {
        $request->validate([
            'seat_number' => 'required|string|max:10',
            'row_number'  => 'required|string|max:5',
            'seat_type'   => 'required|in:standard,vip,wheelchair',
        ]);

        $seat->update([
            'seat_number' => strtoupper($request->seat_number),
            'row_number'  => strtoupper($request->row_number),
            'seat_type'   => $request->seat_type,
        ]);

        return redirect()->route('admin.halls.seats.index', $seat->hall_id)
                 ->with('success', 'Seat updated successfully.');
    }

    public function destroy(Seat $seat)
    {
        $hallId = $seat->hall_id;
        $seat->delete();

        return redirect()->route('admin.halls.seats.index', $hallId)
                 ->with('success', 'Seat deleted successfully.');
    }
}