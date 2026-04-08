<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalMovies'   => Movie::count(),
            'totalBookings' => Booking::count(),
            'totalUsers'    => User::count(),
            'totalRevenue'  => Payment::where('payment_status', 'paid')->sum('amount'),
            'recentBookings' => Booking::with(['user', 'showtime.movie'])
                                    ->latest('booking_date')
                                    ->limit(5)
                                    ->get(),
        ]);
    }
}