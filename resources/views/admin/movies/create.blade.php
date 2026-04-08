@extends('admin.layouts.app')
@section('title', 'Add Movie')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.movies.index') }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to movies
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-6">Add New Movie</h2>

            <form method="POST" action="{{ route('admin.movies.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                               rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-transparent transition
                               @error('title') border-red-500 @enderror"/>
                    @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                               rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-transparent transition resize-none
                               @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Duration (minutes)</label>
                        <input type="number" name="duration" value="{{ old('duration') }}" min="1" required
                            class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                                   rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                                   focus:ring-blue-500 focus:border-transparent transition
                                   @error('duration') border-red-500 @enderror"/>
                        @error('duration') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Release Date</label>
                        <input type="date" name="release_date" value="{{ old('release_date') }}"
                            class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                                   rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                                   focus:ring-blue-500 focus:border-transparent transition
                                   @error('release_date') border-red-500 @enderror"/>
                        @error('release_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Genre</label>
                    <select name="genre_id"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('genre_id') border-red-500 @enderror">
                        <option value="">— Select genre —</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->genre_id }}"
                                {{ old('genre_id') == $genre->genre_id ? 'selected' : '' }}>
                                {{ $genre->genre_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Save Movie
                    </button>
                    <a href="{{ route('admin.movies.index') }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection