@extends('admin.layouts.app')
@section('title', 'Cinemas & Halls')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">All Cinemas</h2>
        <a href="{{ route('admin.cinemas.create') }}"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add Cinema
        </a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">#</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Name</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Location</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Halls</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($cinemas as $cinema)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $cinema->cinema_id }}</td>
                            <td class="px-5 py-3 text-white font-medium">{{ $cinema->name }}</td>
                            <td class="px-5 py-3 text-gray-400">{{ $cinema->location ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.cinemas.halls.index', $cinema->cinema_id) }}"
                                    class="px-2 py-1 bg-teal-500/10 text-teal-400 rounded-full text-xs hover:bg-teal-500/20 transition">
                                    {{ $cinema->halls_count }} hall(s)
                                </a>
                            </td>
                            <td class="px-5 py-3 flex items-center gap-2">
                                <a href="{{ route('admin.cinemas.edit', $cinema->cinema_id) }}"
                                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.cinemas.destroy', $cinema->cinema_id) }}"
                                    onsubmit="return confirm('Delete this cinema and all its halls?')">
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
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                No cinemas found. Add one to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($cinemas->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $cinemas->links() }}</div>
        @endif
    </div>

@endsection