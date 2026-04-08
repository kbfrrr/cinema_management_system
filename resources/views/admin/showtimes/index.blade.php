@extends('admin.layouts.app')
@section('title', 'Showtimes')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">All Showtimes</h2>
        <a href="{{ route('admin.showtimes.create') }}"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add Showtime
        </a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">#</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Movie</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Cinema / Hall</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Start</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">End</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Price</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($showtimes as $showtime)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $showtime->showtime_id }}</td>
                            <td class="px-5 py-3 text-white font-medium">{{ $showtime->movie->title }}</td>
                            <td class="px-5 py-3">
                                <p class="text-white">{{ $showtime->hall->cinema->name }}</p>
                                <p class="text-xs text-gray-400">{{ $showtime->hall->hall_name }}</p>
                            </td>
                            <td class="px-5 py-3 text-gray-300">
                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, Y g:i A') }}
                            </td>
                            <td class="px-5 py-3 text-gray-300">
                                {{ \Carbon\Carbon::parse($showtime->end_time)->format('M d, Y g:i A') }}
                            </td>
                            <td class="px-5 py-3 text-green-400 font-medium">
                                ₱{{ number_format($showtime->price, 2) }}
                            </td>
                            <td class="px-5 py-3 flex items-center gap-2">
                                <a href="{{ route('admin.showtimes.edit', $showtime->showtime_id) }}"
                                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.showtimes.destroy', $showtime->showtime_id) }}"
                                    onsubmit="return confirm('Delete this showtime?')">
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
                            <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                No showtimes found. Add one to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($showtimes->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $showtimes->links() }}</div>
        @endif
    </div>

@endsection