@extends('admin.layouts.app')
@section('title', 'Add Showtime')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.showtimes.index') }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to showtimes
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-6">Add New Showtime</h2>

            <form method="POST" action="{{ route('admin.showtimes.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Movie</label>
                    <select name="movie_id" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('movie_id') border-red-500 @enderror">
                        <option value="">— Select movie —</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->movie_id }}"
                                {{ old('movie_id') == $movie->movie_id ? 'selected' : '' }}>
                                {{ $movie->title }} ({{ $movie->duration }} mins)
                            </option>
                        @endforeach
                    </select>
                    @error('movie_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Hall</label>
                    <select name="hall_id" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('hall_id') border-red-500 @enderror">
                        <option value="">— Select hall —</option>
                        @foreach($halls as $hall)
                            <option value="{{ $hall->hall_id }}"
                                {{ old('hall_id') == $hall->hall_id ? 'selected' : '' }}>
                                {{ $hall->cinema->name }} — {{ $hall->hall_name }} ({{ $hall->capacity }} seats)
                            </option>
                        @endforeach
                    </select>
                    @error('hall_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Start Time</label>
                        <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('start_time') border-red-500 @enderror"/>
                        @error('start_time') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">End Time</label>
                        <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('end_time') border-red-500 @enderror"/>
                        @error('end_time') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Ticket Price (₱)</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required
                        placeholder="e.g. 250.00"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('price') border-red-500 @enderror"/>
                    @error('price') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Save Showtime
                    </button>
                    <a href="{{ route('admin.showtimes.index') }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection