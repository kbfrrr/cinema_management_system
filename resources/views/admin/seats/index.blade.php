@extends('admin.layouts.app')
@section('title', 'Seats — ' . $hall->hall_name)

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.cinemas.halls.index', $hall->cinema_id) }}"
                class="text-sm text-gray-400 hover:text-white transition inline-flex items-center gap-1 mb-1">
                ← Back to halls
            </a>
            <h2 class="text-lg font-semibold text-white">{{ $hall->hall_name }} — Seats</h2>
            <p class="text-sm text-gray-400">{{ $hall->cinema->name }} &middot; Capacity: {{ $hall->capacity }}</p>
        </div>
        <a href="{{ route('admin.halls.seats.create', $hall->hall_id) }}"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add Seats
        </a>
    </div>

    {{-- Seat grid preview --}}
    @if($seats->isNotEmpty())
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5 mb-6">
            <p class="text-xs text-gray-400 mb-4">Seat map preview</p>
            <div class="space-y-2">
                @foreach($seats->groupBy('row_number') as $row => $rowSeats)
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-gray-500 w-4 shrink-0">{{ $row }}</span>
                        @foreach($rowSeats as $seat)
                            <div class="w-7 h-7 rounded-md text-xs flex items-center justify-center
                                {{ $seat->seat_type === 'vip'
                                    ? 'bg-amber-600/40 border border-amber-600/60 text-amber-300'
                                    : ($seat->seat_type === 'wheelchair'
                                        ? 'bg-teal-600/40 border border-teal-600/60 text-teal-300'
                                        : 'bg-gray-700 border border-gray-600 text-gray-300') }}"
                                title="{{ $seat->seat_number }} ({{ $seat->seat_type }})">
                                {{ substr($seat->seat_number, -1) }}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="flex gap-4 mt-4 text-xs text-gray-500">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-gray-700 inline-block"></span> Standard
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-amber-600/40 inline-block"></span> VIP
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-teal-600/40 inline-block"></span> Wheelchair
                </span>
            </div>
        </div>
    @endif

    {{-- Seat table --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Seat</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Row</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Type</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($seats as $seat)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-white font-medium">{{ $seat->seat_number }}</td>
                            <td class="px-5 py-3 text-gray-400">{{ $seat->row_number }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $seat->seat_type === 'vip'
                                        ? 'bg-amber-500/10 text-amber-400'
                                        : ($seat->seat_type === 'wheelchair'
                                            ? 'bg-teal-500/10 text-teal-400'
                                            : 'bg-gray-500/10 text-gray-400') }}">
                                    {{ ucfirst($seat->seat_type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 flex items-center gap-2">
                                <a href="{{ route('admin.seats.edit', $seat->seat_id) }}"
                                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.seats.destroy', $seat->seat_id) }}"
                                    onsubmit="return confirm('Delete this seat?')">
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
                                No seats yet. Add some to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($seats->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $seats->links() }}</div>
        @endif
    </div>

@endsection