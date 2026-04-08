@extends('customer.layouts.app')
@section('title', $movie->title)

@section('content')

    <div class="max-w-5xl mx-auto px-4 py-10">

        {{-- Back --}}
        <a href="{{ route('customer.home') }}"
            class="text-sm text-gray-400 hover:text-white transition inline-flex items-center gap-1 mb-6">
            ← Back to movies
        </a>

        {{-- Movie header --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row gap-6 p-6">

                {{-- Poster --}}
                <div class="w-full sm:w-40 shrink-0">
                    <div class="aspect-[2/3] bg-gray-800 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0
                                   001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                        <h1 class="text-2xl font-bold text-white">{{ $movie->title }}</h1>
                        @if($movie->genre)
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-full text-xs">
                                {{ $movie->genre->genre_name }}
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-400">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $movie->duration }} minutes
                        </span>
                        @if($movie->release_date)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2
                                           2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') }}
                            </span>
                        @endif
                        @if($movie->reviews->count() > 0)
                            <span class="flex items-center gap-1.5 text-amber-400">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0
                                        00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364
                                        1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0
                                        00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                        1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1
                                        0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ number_format($movie->reviews->avg('rating'), 1) }}
                                ({{ $movie->reviews->count() }} reviews)
                            </span>
                        @endif
                    </div>

                    @if($movie->description)
                        <p class="text-gray-400 text-sm leading-relaxed">{{ $movie->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Showtimes --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 mb-6">
            <div class="px-5 py-4 border-b border-gray-800">
                <h2 class="text-base font-semibold text-white">Available Showtimes</h2>
            </div>

            @if($movie->showtimes->isEmpty())
                <div class="px-5 py-10 text-center">
                    <p class="text-gray-500">No upcoming showtimes available.</p>
                </div>
            @else
                <div class="divide-y divide-gray-800">
                    @foreach($movie->showtimes as $showtime)
                        <div class="px-5 py-4 flex flex-wrap items-center justify-between gap-4
                                    hover:bg-gray-800/50 transition">
                            <div class="flex flex-wrap gap-6">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Cinema</p>
                                    <p class="text-sm text-white font-medium">
                                        {{ $showtime->hall->cinema->name }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $showtime->hall->hall_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Date</p>
                                    <p class="text-sm text-white font-medium">
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Time</p>
                                    <p class="text-sm text-white font-medium">
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('g:i A') }}
                                        —
                                        {{ \Carbon\Carbon::parse($showtime->end_time)->format('g:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Price</p>
                                    <p class="text-sm text-green-400 font-semibold">
                                        ₱{{ number_format($showtime->price, 2) }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('customer.seats', $showtime->showtime_id) }}"
                                class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium
                                       px-5 py-2 rounded-lg transition shrink-0">
                                Select Seats
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Reviews --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800">
            <div class="px-5 py-4 border-b border-gray-800">
                <h2 class="text-base font-semibold text-white">Reviews</h2>
            </div>

            @if($movie->reviews->isEmpty())
                <div class="px-5 py-10 text-center">
                    <p class="text-gray-500 text-sm">No reviews yet.</p>
                </div>
            @else
                <div class="divide-y divide-gray-800">
                    @foreach($movie->reviews as $review)
                        <div class="px-5 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center
                                                justify-center text-xs font-bold text-white">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-white font-medium">{{ $review->user->name }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-600' }} fill-current"
                                            viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1
                                                0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1
                                                0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8
                                                -2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197
                                                -1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783
                                                -.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-sm text-gray-400">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

@endsection