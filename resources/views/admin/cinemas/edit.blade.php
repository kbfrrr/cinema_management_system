@extends('admin.layouts.app')
@section('title', 'Edit Cinema')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.cinemas.index') }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to cinemas
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-6">Edit Cinema</h2>

            <form method="POST" action="{{ route('admin.cinemas.update', $cinema->cinema_id) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Cinema Name</label>
                    <input type="text" name="name" value="{{ old('name', $cinema->name) }}" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('name') border-red-500 @enderror"/>
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Location</label>
                    <input type="text" name="location" value="{{ old('location', $cinema->location) }}"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('location') border-red-500 @enderror"/>
                    @error('location') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Update Cinema
                    </button>
                    <a href="{{ route('admin.cinemas.index') }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection