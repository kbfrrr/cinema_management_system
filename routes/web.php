<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\CinemaController;
use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SeatController as AdminSeatController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MovieController as CustomerMovieController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\SeatController as CustomerSeatController;
use App\Http\Controllers\Customer\CheckoutController;
use Illuminate\Support\Facades\Route;

// ── Auth routes ──────────────────────────────────────────────────────────────
Route::get('/login',    [LoginController::class, 'showLogin'])->name('login');
Route::post('/login',   [LoginController::class, 'login']);
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register',[LoginController::class, 'register']);
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');

Route::get('/', fn() => redirect()->route('customer.home'));

// ── Admin routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth.session')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('movies',        MovieController::class);
    Route::resource('cinemas',       CinemaController::class);
    Route::resource('cinemas.halls', HallController::class)->shallow();
    Route::resource('halls.seats',   AdminSeatController::class)->shallow();
    Route::resource('showtimes',     ShowtimeController::class);
    Route::resource('users',         UserController::class)->except(['show']);
    Route::get('bookings',                    [BookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
});

// ── Customer routes ───────────────────────────────────────────────────────────
Route::prefix('')->name('customer.')->middleware('auth.session')->group(function () {
    Route::get('/home',             [HomeController::class, 'index'])->name('home');
    Route::get('/movies',           [HomeController::class, 'filter'])->name('movies');
    Route::get('/movie/{id}',       [CustomerMovieController::class, 'show'])->name('movie');
    Route::get('/seats/{showtime_id}', [CustomerSeatController::class, 'show'])->name('seats');
    Route::get('/checkout',         [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout',        [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/bookings',         [CustomerBookingController::class, 'index'])->name('bookings');
});