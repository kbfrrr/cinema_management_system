@extends('customer.layouts.app')
@section('title', 'Checkout')

@section('content')

    <div class="max-w-2xl mx-auto px-4 py-10">

        {{-- Back --}}
        <a href="{{ url()->previous() }}"
            class="text-sm text-gray-400 hover:text-white transition inline-flex items-center gap-1 mb-6">
            ← Back to seats
        </a>

        <h1 class="text-2xl font-bold text-white mb-6">Checkout</h1>

        @if(session('error'))
            <div class="mb-6 flex items-start gap-3 bg-red-500/10 border border-red-500/30
                        text-red-400 text-sm rounded-lg px-4 py-3">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-4.75a.75.75
                        0 001.5 0v-4.5a.75.75 0 00-1.5 0v4.5zm.75-7a.75.75 0 100 1.5.75.75 0
                        000-1.5z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Order summary --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 mb-5">
            <div class="px-5 py-4 border-b border-gray-800">
                <h2 class="text-sm font-semibold text-white">Order Summary</h2>
            </div>

            <div class="px-5 py-4 space-y-4">

                {{-- Movie & showtime --}}
                <div class="flex justify-between text-sm">
                    <div>
                        <p class="text-white font-medium">{{ $showtime->movie->title }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">
                            {{ $showtime->hall->cinema->name }} &middot; {{ $showtime->hall->hall_name }}
                        </p>
                        <p class="text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, Y g:i A') }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-4">
                    <p class="text-xs text-gray-500 mb-2">Selected Seats</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($seats as $seat)
                            <span class="bg-gray-800 text-gray-300 text-xs px-2.5 py-1 rounded-lg
                                         border border-gray-700">
                                {{ $seat->seat_number }}
                                @if($seat->seat_type === 'vip')
                                    <span class="text-amber-400 ml-1">VIP</span>
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-400">
                        <span>Price per seat</span>
                        <span>₱{{ number_format($showtime->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>Number of seats</span>
                        <span>{{ $seats->count() }}</span>
                    </div>
                    <div class="flex justify-between text-white font-bold text-base pt-2
                                border-t border-gray-800">
                        <span>Total</span>
                        <span class="text-green-400">₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Payment form --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 mb-5">
            <div class="px-5 py-4 border-b border-gray-800">
                <h2 class="text-sm font-semibold text-white">Payment Method</h2>
            </div>

            <form method="POST" action="{{ route('customer.checkout.store') }}" id="payment-form">
                @csrf
                <input type="hidden" name="showtime_id" value="{{ $showtime->showtime_id }}">
                <input type="hidden" name="seat_ids"    value="{{ $seats->pluck('seat_id')->join(',') }}">

                <div class="px-5 py-4 space-y-3">

                    @foreach(['GCash', 'Card', 'Cash'] as $method)
                        <label class="flex items-center gap-4 p-4 rounded-lg border border-gray-700
                                      hover:border-blue-500/50 cursor-pointer transition
                                      has-[:checked]:border-blue-500 has-[:checked]:bg-blue-500/5">
                            <input type="radio" name="payment_method" value="{{ $method }}"
                                class="accent-blue-500 w-4 h-4"
                                {{ $loop->first ? 'checked' : '' }}/>
                            <div class="flex items-center gap-3">
                                @if($method === 'GCash')
                                    <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center
                                                justify-center text-blue-400 text-xs font-bold">G</div>
                                @elseif($method === 'Card')
                                    <div class="w-8 h-8 bg-purple-600/20 rounded-lg flex items-center
                                                justify-center">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center
                                                justify-center">
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2
                                                   4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="text-sm text-white font-medium">{{ $method }}</span>
                            </div>
                        </label>
                    @endforeach

                </div>

                {{-- Confirm button --}}
                <div class="px-5 pb-5">
                    <button type="submit"
                        onclick="this.disabled=true; this.textContent='Processing...'; this.form.submit();"
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold
                               py-3 rounded-lg transition text-sm">
                        Confirm Booking — ₱{{ number_format($total, 2) }}
                    </button>
                    <p class="text-center text-gray-500 text-xs mt-3">
                        By confirming you agree to our booking terms.
                    </p>
                </div>

            </form>
        </div>

    </div>

@endsection