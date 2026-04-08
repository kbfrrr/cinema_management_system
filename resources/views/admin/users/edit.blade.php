@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.users.index') }}"
            class="text-sm text-gray-400 hover:text-white transition mb-6 inline-flex items-center gap-1">
            ← Back to users
        </a>

        <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 mt-4">
            <h2 class="text-base font-semibold text-white mb-6">Edit User</h2>

            <form method="POST" action="{{ route('admin.users.update', $user->user_id) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                               @error('name') border-red-500 @enderror"/>
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
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
                                {{ old('role_id', $user->role_id) == $role->role_id ? 'selected' : '' }}>
                                {{ ucfirst($role->role_name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">
                            New Password
                            <span class="text-gray-500">(leave blank to keep current)</span>
                        </label>
                        <input type="password" name="password"
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                   @error('password') border-red-500 @enderror"/>
                        @error('password') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-300 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                                   text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"/>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                        Update User
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