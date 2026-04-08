@extends('admin.layouts.app')
@section('title', 'Add Seats')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.halls.seats.index', $hall->hall_id) }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to seats
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-1">Add Seats</h2>
            <p class="text-sm text-gray-400 mb-6">
                {{ $hall->hall_name }} &middot; {{ $hall->cinema->name }}
            </p>

            <form method="POST" action="{{ route('admin.halls.seats.store', $hall->hall_id) }}"

                class="space-y-5" id="seat-form">
                @csrf

                {{-- Mode toggle --}}
                <div class="flex rounded-lg overflow-hidden border border-gray-700">
                    <button type="button" onclick="setMode('bulk')" id="btn-bulk"
                        class="flex-1 py-2 text-sm font-medium transition bg-blue-600 text-white">
                        Bulk Generate
                    </button>
                    <button type="button" onclick="setMode('single')" id="btn-single"
                        class="flex-1 py-2 text-sm font-medium transition bg-gray-800 text-gray-400">
                        Single Seat
                    </button>
                </div>

                {{-- Bulk generate --}}
                <div id="bulk-section" class="space-y-4">
                    <input type="hidden" name="generate" id="generate-input" value="yes">

                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">
                            Row letters
                            <span class="text-gray-500">(comma separated, e.g. A,B,C,D,E)</span>
                        </label>
                        <input type="text" name="rows" value="{{ old('rows', 'A,B,C,D,E') }}"
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('rows') border-red-500 @enderror"/>
                        @error('rows') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Seats per row</label>
                        <input type="number" name="seats_per_row" value="{{ old('seats_per_row', 10) }}"
                            min="1" max="50"
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('seats_per_row') border-red-500 @enderror"/>
                        @error('seats_per_row') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Single seat --}}
                <div id="single-section" class="space-y-4 hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-300 mb-1.5">Seat Number</label>
                            <input type="text" name="seat_number" value="{{ old('seat_number') }}"
                                placeholder="e.g. A1"
                                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                       text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                       @error('seat_number') border-red-500 @enderror"/>
                            @error('seat_number') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-300 mb-1.5">Row</label>
                            <input type="text" name="row_number" value="{{ old('row_number') }}"
                                placeholder="e.g. A"
                                class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                       text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                       @error('row_number') border-red-500 @enderror"/>
                            @error('row_number') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Seat type (shared) --}}
                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Seat Type</label>
                    <select name="seat_type"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="standard" {{ old('seat_type') === 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="vip"      {{ old('seat_type') === 'vip'      ? 'selected' : '' }}>VIP</option>
                        <option value="wheelchair" {{ old('seat_type') === 'wheelchair' ? 'selected' : '' }}>Wheelchair</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Generate Seats
                    </button>
                    <a href="{{ route('admin.halls.seats.index', $hall->hall_id) }}"

                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function setMode(mode) {
            const bulk   = document.getElementById('bulk-section');
            const single = document.getElementById('single-section');
            const btnB   = document.getElementById('btn-bulk');
            const btnS   = document.getElementById('btn-single');
            const genIn  = document.getElementById('generate-input');
            const btn    = document.querySelector('button[type=submit]');

            if (mode === 'bulk') {
                bulk.classList.remove('hidden');
                single.classList.add('hidden');
                btnB.classList.replace('bg-gray-800', 'bg-blue-600');
                btnB.classList.replace('text-gray-400', 'text-white');
                btnS.classList.replace('bg-blue-600', 'bg-gray-800');
                btnS.classList.replace('text-white', 'text-gray-400');
                genIn.value  = 'yes';
                btn.textContent = 'Generate Seats';
            } else {
                single.classList.remove('hidden');
                bulk.classList.add('hidden');
                btnS.classList.replace('bg-gray-800', 'bg-blue-600');
                btnS.classList.replace('text-gray-400', 'text-white');
                btnB.classList.replace('bg-blue-600', 'bg-gray-800');
                btnB.classList.replace('text-white', 'text-gray-400');
                genIn.value  = '';
                btn.textContent = 'Add Seat';
            }
        }
    </script>

@endsection