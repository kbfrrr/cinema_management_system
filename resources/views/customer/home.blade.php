@extends('customer.layouts.app')
@section('title', 'Now Showing')

@section('content')

    {{-- Hero --}}
    <div class="bg-gradient-to-b from-gray-900 to-gray-950 border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-4 py-14 text-center">
            <h1 class="text-4xl font-bold text-white mb-3">Now Showing</h1>
            <p class="text-gray-400 text-base mb-8">Book your seats for the latest movies</p>

            {{-- Search --}}
            <form method="GET" action="{{ route('customer.movies') }}"
                class="flex gap-2 max-w-xl mx-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search movies..."
                    class="flex-1 bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                           rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                           focus:ring-blue-500 transition"/>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium
                           px-5 py-2.5 rounded-lg transition">
                    Search
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Genre filter --}}
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('customer.home') }}"
                class="px-4 py-1.5 rounded-full text-sm transition
                       {{ ! request('genre_id') ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                All
            </a>
            @foreach($genres as $genre)
                <a href="{{ route('customer.movies', ['genre_id' => $genre->genre_id]) }}"
                    class="px-4 py-1.5 rounded-full text-sm transition
                           {{ request('genre_id') == $genre->genre_id ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    {{ $genre->genre_name }}
                </a>
            @endforeach
        </div>

        {{-- Movies grid --}}
        @if($movies->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg">No movies found.</p>
                <a href="{{ route('customer.home') }}"
                    class="text-blue-400 hover:text-blue-300 text-sm mt-2 inline-block transition">
                    Clear filters
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($movies as $movie)
                    <a href="{{ route('customer.movie', $movie->movie_id) }}"
                        class="group bg-gray-900 rounded-xl border border-gray-800 overflow-hidden
                               hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition">

                        {{-- Poster placeholder --}}
                        <div class="aspect-[2/3] bg-gray-800 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/30 to-gray-900/60"></div>
                            <svg class="w-12 h-12 text-gray-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0
                                       001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                            </svg>
                            {{-- Duration badge --}}
                            <div class="absolute bottom-2 right-2 bg-black/70 text-gray-300 text-xs
                                        px-2 py-0.5 rounded-full">
                                {{ $movie->duration }} min
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-3">
                            <h3 class="text-white font-semibold text-sm leading-snug group-hover:text-blue-400
                                       transition line-clamp-2">
                                {{ $movie->title }}
                            </h3>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-gray-400 bg-gray-800 px-2 py-0.5 rounded-full">
                                    {{ $movie->genre->genre_name ?? 'N/A' }}
                                </span>
                                @if($movie->release_date)
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-3">
                                <span class="w-full block text-center bg-blue-600/20 hover:bg-blue-600
                                             text-blue-400 hover:text-white text-xs font-medium py-1.5
                                             rounded-lg transition">
                                    Book Now
                                </span>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($movies->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $movies->links() }}
                </div>
            @endif
        @endif

    </div>

@endsection