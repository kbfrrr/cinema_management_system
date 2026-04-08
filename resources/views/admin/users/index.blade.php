@extends('admin.layouts.app')
@section('title', 'Users')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">All Users</h2>
        <a href="{{ route('admin.users.create') }}"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add User
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
        class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search name or email..."
            class="bg-gray-800 border border-gray-700 text-white placeholder-gray-500 rounded-lg
                   px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition w-64"/>
        <select name="role"
            class="bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <option value="">All roles</option>
            <option value="admin"    {{ request('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
            <option value="staff"    {{ request('role') === 'staff'    ? 'selected' : '' }}>Staff</option>
            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
        </select>
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm px-4 py-2 rounded-lg transition">
            Filter
        </button>
        @if(request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded-lg transition">
                Clear
            </a>
        @endif
    </form>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">#</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Name</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Email</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Role</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Joined</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $user->user_id }}</td>

                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center
                                                text-xs font-bold text-white shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-white font-medium">{{ $user->name }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-3 text-gray-400">{{ $user->email }}</td>

                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $user->role->role_name === 'admin'
                                        ? 'bg-purple-500/10 text-purple-400'
                                        : ($user->role->role_name === 'staff'
                                            ? 'bg-blue-500/10 text-blue-400'
                                            : 'bg-gray-500/10 text-gray-400') }}">
                                    {{ ucfirst($user->role->role_name) }}
                                </span>
                            </td>

                            <td class="px-5 py-3 text-gray-400">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                            </td>

                            <td class="px-5 py-3 flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->user_id) }}"
                                    class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition">
                                    Edit
                                </a>
                                @if($user->user_id !== session('user_id'))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->user_id) }}"
                                        onsubmit="return confirm('Delete this user?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs rounded-lg transition">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="px-3 py-1 text-gray-600 text-xs">You</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $users->links() }}</div>
        @endif
    </div>

@endsection