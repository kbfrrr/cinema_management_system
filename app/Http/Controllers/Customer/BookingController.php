<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
                        'showtime.movie',
                        'showtime.hall.cinema',
                        'bookingSeats.seat',
                        'payment',
                        'tickets',
                    ])
                    ->where('user_id', session('user_id'))
                    ->orderBy('booking_date', 'desc')
                    ->get();

        return view('customer.bookings', compact('bookings'));
    }
}