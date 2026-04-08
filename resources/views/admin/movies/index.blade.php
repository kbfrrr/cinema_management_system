@extends('admin.layouts.app')
@section('title', 'Movies')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">All Movies</h2>
        <a href="{{ route('admin.movies.create') }}"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add Movie
        </a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">#</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Title</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Genre</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Duration</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Release Date</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($movies as $movie)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $movie->movie_id }}</td>
                            <td class="px-5 py-3 text-white font-medium">{{ $movie->title }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 bg-blue-500/10 text-blue-400 rounded-full text-xs">
                                    {{ $movie->genre->genre_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-400">{{ $movie->duration }} mins</td>
                            <td class="px-5 py-3 text-gray-400">
                                {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-5 py-3 flex items-center gap-2">
                                <a href="{{ route('admin.movies.edit', $movie->movie_id) }}"
                                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.movies.destroy', $movie->movie_id) }}"
                                    onsubmit="return confirm('Delete this movie?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs rounded-lg transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                No movies found. Add one to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($movies->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">
                {{ $movies->links() }}
            </div>
        @endif
    </div>

@endsection