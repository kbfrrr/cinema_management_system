@extends('customer.layouts.app')
@section('title', 'My Bookings')

@section('content')

    <div class="max-w-4xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-bold text-white mb-8">My Bookings</h1>

        @if($bookings->isEmpty())
            <div class="bg-gray-900 rounded-xl border border-gray-800 p-16 text-center">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002
                           2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                <p class="text-gray-400 font-medium">No bookings yet</p>
                <p class="text-gray-500 text-sm mt-1">Book a movie to see it here</p>
                <a href="{{ route('customer.home') }}"
                    class="mt-5 inline-block bg-blue-600 hover:bg-blue-500 text-white text-sm
                           font-medium px-6 py-2.5 rounded-lg transition">
                    Browse Movies
                </a>
            </div>
        @else
            <div class="space-y-5">
                @foreach($bookings as $booking)
                    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">

                        {{-- Booking header --}}
                        <div class="px-5 py-4 border-b border-gray-800 flex items-center justify-between">
                            <div>
                                <h2 class="text-white font-semibold">
                                    {{ $booking->showtime->movie->title }}
                                </h2>
                                <p class="text-gray-400 text-xs mt-0.5">
                                    Booking #{{ $booking->booking_id }} &middot;
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y g:i A') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed'
                                    ? 'bg-green-500/10 text-green-400'
                                    : 'bg-red-500/10 text-red-400' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>

                        {{-- Booking details --}}
                        <div class="px-5 py-4 grid grid-cols-2 sm:grid-cols-4 gap-4 border-b border-gray-800">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Cinema</p>
                                <p class="text-sm text-white">{{ $booking->showtime->hall->cinema->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Hall</p>
                                <p class="text-sm text-white">{{ $booking->showtime->hall->hall_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Showtime</p>
                                <p class="text-sm text-white">
                                    {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Seats</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($booking->bookingSeats as $bs)
                                        <span class="bg-gray-800 text-gray-300 text-xs px-2 py-0.5 rounded">
                                            {{ $bs->seat->seat_number }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Payment & tickets --}}
                        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-4">
                                {{-- Payment status --}}
                                @if($booking->payment)
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Payment</p>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                                {{ $booking->payment->payment_status === 'paid'
                                                    ? 'bg-green-500/10 text-green-400'
                                                    : ($booking->payment->payment_status === 'pending'
                                                        ? 'bg-amber-500/10 text-amber-400'
                                                        : 'bg-red-500/10 text-red-400') }}">
                                                {{ ucfirst($booking->payment->payment_status) }}
                                            </span>
                                            <span class="text-sm text-white font-medium">
                                                ₱{{ number_format($booking->payment->amount, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Payment</p>
                                        <span class="text-xs text-gray-500">No payment recorded</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Tickets --}}
                            @if($booking->tickets->isNotEmpty())
                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Tickets</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($booking->tickets as $ticket)
                                            <div class="bg-gray-800 border border-gray-700 rounded-lg
                                                        px-3 py-2 flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0
                                                        00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0
                                                        002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                                </svg>
                                                <span class="text-xs text-gray-300 font-mono">
                                                    {{ $ticket->seat->seat_number }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ substr($ticket->ticket_code, 0, 8) }}...
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

@endsection