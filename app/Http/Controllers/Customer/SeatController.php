<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BookingSeat;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function show(int $showtime_id)
    {
        $showtime = Showtime::with(['movie', 'hall.cinema'])->findOrFail($showtime_id);

        $seats = Seat::where('hall_id', $showtime->hall_id)
            ->orderBy('row_number')
            ->orderBy('seat_number')
            ->get();

        $bookedSeatIds = BookingSeat::whereHas('booking', function ($query) use ($showtime) {
                $query->where('showtime_id', $showtime->showtime_id);
            })
            ->pluck('seat_id')
            ->toArray();

        $seatsByRow = $seats->groupBy('row_number');

        return view('customer.seats', compact('showtime', 'seatsByRow', 'bookedSeatIds'));
    }
}
