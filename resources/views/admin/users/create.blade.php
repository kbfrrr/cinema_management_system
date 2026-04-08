@extends('admin.layouts.app')
@section('title', 'Add User')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.users.index') }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to users
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-6">Add New User</h2>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('name') border-red-500 @enderror"/>
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('email') border-red-500 @enderror"/>
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Role</label>
                    <select name="role_id" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('role_id') border-red-500 @enderror">
                        <option value="">— Select role —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->role_id }}"
                                {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                {{ ucfirst($role->role_name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('password') border-red-500 @enderror"/>
                        @error('password') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"/>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection