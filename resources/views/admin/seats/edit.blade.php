@extends('admin.layouts.app')
@section('title', 'Edit Seat')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.halls.seats.index', $seat->hall_id) }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to seats
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-1">Edit Seat</h2>
            <p class="text-sm text-gray-400 mb-6">{{ $seat->hall->hall_name }} &middot; {{ $seat->hall->cinema->name }}</p>

            <form method="POST" action="{{ route('admin.seats.update', $seat->seat_id) }}" class="space-y-5">
                @csrf @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Seat Number</label>
                        <input type="text" name="seat_number"
                            value="{{ old('seat_number', $seat->seat_number) }}" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('seat_number') border-red-500 @enderror"/>
                        @error('seat_number') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Row</label>
                        <input type="text" name="row_number"
                            value="{{ old('row_number', $seat->row_number) }}" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('row_number') border-red-500 @enderror"/>
                        @error('row_number') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Seat Type</label>
                    <select name="seat_type"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="standard"   {{ old('seat_type', $seat->seat_type) === 'standard'   ? 'selected' : '' }}>Standard</option>
                        <option value="vip"        {{ old('seat_type', $seat->seat_type) === 'vip'        ? 'selected' : '' }}>VIP</option>
                        <option value="wheelchair" {{ old('seat_type', $seat->seat_type) === 'wheelchair' ? 'selected' : '' }}>Wheelchair</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Update Seat
                    </button>
                    <a href="{{ route('admin.halls.seats.index', $seat->hall_id) }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection