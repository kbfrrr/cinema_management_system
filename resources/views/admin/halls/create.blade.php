@extends('admin.layouts.app')
@section('title', 'Add Hall')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.cinemas.halls.index', $cinema->cinema_id) }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to halls
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-1">Add Hall</h2>
            <p class="text-sm text-gray-400 mb-6">{{ $cinema->name }}</p>

            <form method="POST" action="{{ route('admin.cinemas.halls.store', $cinema->cinema_id) }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Hall Name</label>
                    <input type="text" name="hall_name" value="{{ old('hall_name') }}" required
                        placeholder="e.g. Hall A, Cinema 1"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('hall_name') border-red-500 @enderror"/>
                    @error('hall_name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Capacity</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" required
                        placeholder="e.g. 150"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('capacity') border-red-500 @enderror"/>
                    @error('capacity') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Save Hall
                    </button>
                    <a href="{{ route('admin.cinemas.halls.index', $cinema->cinema_id) }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection