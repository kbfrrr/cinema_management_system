<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,showtime_id',
            'seats'       => 'required|string',
        ]);

        $seatIds  = explode(',', $request->seats);
        $showtime = Showtime::with(['movie', 'hall.cinema'])->findOrFail($request->showtime_id);
        $seats    = Seat::whereIn('seat_id', $seatIds)->get();

        if ($seats->isEmpty()) {
            return redirect()->back()->with('error', 'No seats selected.');
        }

        // Check if any selected seat is already booked
        $alreadyBooked = BookingSeat::whereIn('seat_id', $seatIds)
                            ->whereHas('booking', fn($q) =>
                                $q->where('showtime_id', $showtime->showtime_id)
                                  ->where('status', 'confirmed'))
                            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'One or more seats were just taken. Please reselect.');
        }

        $total = $seats->count() * $showtime->price;

        return view('customer.checkout', compact('showtime', 'seats', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id'    => 'required|exists:showtimes,showtime_id',
            'seat_ids'       => 'required|string',
            'payment_method' => 'required|in:GCash,Card,Cash',
        ]);

        $seatIds  = explode(',', $request->seat_ids);
        $showtime = Showtime::findOrFail($request->showtime_id);
        $seats    = Seat::whereIn('seat_id', $seatIds)->get();
        $total    = $seats->count() * $showtime->price;

        try {
            DB::transaction(function () use ($request, $showtime, $seats, $seatIds, $total) {

                // 1. Double-check seats are still available inside transaction
                $alreadyBooked = BookingSeat::whereIn('seat_id', $seatIds)
                                    ->whereHas('booking', fn($q) =>
                                        $q->where('showtime_id', $showtime->showtime_id)
                                          ->where('status', 'confirmed'))
                                    ->exists();

                if ($alreadyBooked) {
                    throw new \Exception('One or more seats were just taken.');
                }

                // 2. Create booking
                $booking = Booking::create([
                    'user_id'     => session('user_id'),
                    'showtime_id' => $showtime->showtime_id,
                    'status'      => 'confirmed',
                ]);

                // 3. Create booking seats
                foreach ($seatIds as $seatId) {
                    BookingSeat::create([
                        'booking_id' => $booking->booking_id,
                        'seat_id'    => $seatId,
                    ]);
                }

                // 4. Create payment
                Payment::create([
                    'booking_id'     => $booking->booking_id,
                    'amount'         => $total,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'paid',
                    'payment_date'   => now(),
                ]);

                // 5. Generate tickets
                foreach ($seats as $seat) {
                    Ticket::create([
                        'booking_id'  => $booking->booking_id,
                        'seat_id'     => $seat->seat_id,
                        'ticket_code' => strtoupper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4)),
                        'issued_at'   => now(),
                    ]);
                }
            });

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('customer.bookings')
                         ->with('success', 'Booking confirmed! Your tickets are ready.');
    }
}