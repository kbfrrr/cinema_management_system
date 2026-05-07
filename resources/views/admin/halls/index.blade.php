@extends('admin.layouts.app')
@section('title', 'Halls — ' . $cinema->name)

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.cinemas.index') }}"
                class="text-sm text-gray-400 hover:text-white transition inline-flex items-center gap-1 mb-1">
                ← Back to cinemas
            </a>
            <h2 class="text-lg font-semibold text-white">{{ $cinema->name }} — Halls</h2>
            <p class="text-sm text-gray-400">{{ $cinema->location }}</p>
        </div>
        <a href="{{ route('admin.cinemas.halls.create', $cinema->cinema_id) }}"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add Hall
        </a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">#</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Hall Name</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Capacity</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($halls as $hall)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $hall->hall_id }}</td>
                            <td class="px-5 py-3 text-white font-medium">{{ $hall->hall_name }}</td>
                            <td class="px-5 py-3 text-gray-400">{{ $hall->capacity }} seats</td>
                            <td class="px-5 py-3 flex items-center gap-2">
                                <a href="{{ route('admin.halls.edit', $hall->hall_id) }}"
                                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                    Edit
                                </a>
                                <a href="{{ route('admin.halls.seats.index', $hall->hall_id) }}"
                                    class="px-3 py-1 bg-teal-500/10 hover:bg-teal-500/20 text-teal-400 text-xs rounded-lg transition">
                                    Seats
                                </a>
                                <form method="POST" action="{{ route('admin.halls.destroy', $hall->hall_id) }}"
                            onsubmit="return confirm('Delete this hall?')">
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
                            <td colspan="4" class="px-5 py-10 text-center text-gray-500">
                                No halls yet. Add one to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($halls->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $halls->links() }}</div>
        @endif
    </div>

@endsection