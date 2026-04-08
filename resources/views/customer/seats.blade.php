@extends('customer.layouts.app')
@section('title', 'Select Seats')

@section('content')

    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- Back --}}
        <a href="{{ route('customer.movie', $showtime->movie->movie_id) }}"
            class="text-sm text-gray-400 hover:text-white transition inline-flex items-center gap-1 mb-6">
            ← Back to movie
        </a>

        {{-- Showtime info --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5 mb-6">
            <div class="flex flex-wrap gap-6 items-center justify-between">
                <div>
                    <h1 class="text-lg font-bold text-white">{{ $showtime->movie->title }}</h1>
                    <p class="text-sm text-gray-400 mt-0.5">
                        {{ $showtime->hall->cinema->name }} &middot; {{ $showtime->hall->hall_name }}
                    </p>
                </div>
                <div class="flex gap-6 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Date</p>
                        <p class="text-white font-medium">
                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Time</p>
                        <p class="text-white font-medium">
                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('g:i A') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Price per seat</p>
                        <p class="text-green-400 font-semibold">₱{{ number_format($showtime->price, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-6 mb-6 text-xs text-gray-400">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-gray-700 border border-gray-600"></div>
                Available
            </div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-blue-600"></div>
                Selected
            </div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-red-900/60 border border-red-800"></div>
                Taken
            </div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-md bg-amber-600/40 border border-amber-600/60"></div>
                VIP
            </div>
        </div>

        {{-- Screen --}}
        <div class="mb-8">
            <div class="w-full max-w-lg mx-auto h-2 bg-gradient-to-r from-transparent via-blue-500/50
                        to-transparent rounded-full mb-1"></div>
            <p class="text-center text-xs text-gray-500 mb-6">SCREEN</p>

            {{-- Seat grid --}}
            @if($seatsByRow->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No seats have been added to this hall yet.</p>
                </div>
            @else
                <div class="space-y-2" id="seat-grid">
                    @foreach($seatsByRow as $row => $seats)
                        <div class="flex items-center gap-2 justify-center">
                            <span class="text-xs text-gray-500 w-5 text-right shrink-0">{{ $row }}</span>
                            <div class="flex gap-1.5 flex-wrap justify-center">
                                @foreach($seats as $seat)
                                    @php
                                        $booked = in_array($seat->seat_id, $bookedSeatIds);
                                        $isVip  = $seat->seat_type === 'vip';
                                    @endphp
                                    @if($booked)
                                        <div class="w-7 h-7 rounded-md bg-red-900/60 border border-red-800
                                                    cursor-not-allowed flex items-center justify-center"
                                            title="Taken">
                                            <span class="text-xs text-red-700">{{ substr($seat->seat_number, -1) }}</span>
                                        </div>
                                    @else
                                        <button type="button"
                                            onclick="toggleSeat(this)"
                                            data-seat-id="{{ $seat->seat_id }}"
                                            data-seat-number="{{ $seat->seat_number }}"
                                            data-seat-type="{{ $seat->seat_type }}"
                                            class="seat w-7 h-7 rounded-md border text-xs transition
                                                   {{ $isVip
                                                       ? 'bg-amber-600/40 border-amber-600/60 text-amber-300 hover:bg-amber-500/60'
                                                       : 'bg-gray-700 border-gray-600 text-gray-300 hover:bg-gray-600' }}">
                                            {{ substr($seat->seat_number, -1) }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Summary & proceed --}}
        <div class="sticky bottom-4">
            <div class="bg-gray-900 border border-gray-700 rounded-xl px-5 py-4 flex flex-wrap
                        items-center justify-between gap-4 shadow-xl">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Selected seats</p>
                    <div id="selected-label" class="text-sm text-white font-medium">None</div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <p class="text-xs text-gray-400 mb-0.5">Total</p>
                        <p id="total-price" class="text-lg font-bold text-green-400">₱0.00</p>
                    </div>
                    <form method="GET" action="{{ route('customer.checkout') }}" id="checkout-form">
                        <input type="hidden" name="showtime_id" value="{{ $showtime->showtime_id }}">
                        <input type="hidden" name="seats" id="seats-input" value="">
                        <button type="submit" id="proceed-btn" disabled
                            class="bg-blue-600 hover:bg-blue-500 disabled:opacity-40 disabled:cursor-not-allowed
                                   text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        const price     = {{ $showtime->price }};
        let selected    = {};

        function toggleSeat(btn) {
            const id     = btn.dataset.seatId;
            const number = btn.dataset.seatNumber;
            const type   = btn.dataset.seatType;
            const isVip  = type === 'vip';

            if (selected[id]) {
                delete selected[id];
                btn.classList.remove('bg-blue-600', 'border-blue-500', 'text-white');
                btn.classList.add(
                    isVip ? 'bg-amber-600/40' : 'bg-gray-700',
                    isVip ? 'border-amber-600/60' : 'border-gray-600',
                    isVip ? 'text-amber-300' : 'text-gray-300'
                );
            } else {
                selected[id] = number;
                btn.classList.remove(
                    'bg-amber-600/40', 'bg-gray-700',
                    'border-amber-600/60', 'border-gray-600',
                    'text-amber-300', 'text-gray-300'
                );
                btn.classList.add('bg-blue-600', 'border-blue-500', 'text-white');
            }

            updateSummary();
        }

        function updateSummary() {
            const ids     = Object.keys(selected);
            const numbers = Object.values(selected);
            const total   = ids.length * price;
            const btn     = document.getElementById('proceed-btn');
            const label   = document.getElementById('selected-label');
            const input   = document.getElementById('seats-input');
            const priceEl = document.getElementById('total-price');

            label.textContent   = numbers.length ? numbers.join(', ') : 'None';
            priceEl.textContent = '₱' + total.toLocaleString('en-PH', { minimumFractionDigits: 2 });
            input.value         = ids.join(',');
            btn.disabled        = ids.length === 0;
        }
    </script>

@endsection