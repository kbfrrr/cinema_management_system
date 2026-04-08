@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

    {{-- Stats grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

        <div class="bg-gray-900 rounded-xl border border-gray-800 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1">Total Movies</p>
            <p class="text-3xl font-bold text-white">{{ $totalMovies }}</p>
        </div>

        <div class="bg-gray-900 rounded-xl border border-gray-800 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1">Total Bookings</p>
            <p class="text-3xl font-bold text-white">{{ $totalBookings }}</p>
        </div>

        <div class="bg-gray-900 rounded-xl border border-gray-800 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1">Total Users</p>
            <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
        </div>

        <div class="bg-gray-900 rounded-xl border border-gray-800 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1">Revenue</p>
            <p class="text-3xl font-bold text-white">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>

    </div>

    {{-- Recent bookings --}}
    <div class="bg-gray-900 rounded-xl border border-gray-800">
        <div class="px-5 py-4 border-b border-gray-800 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-white">Recent Bookings</h2>
            <a href="#" class="text-xs text-blue-400 hover:text-blue-300 transition">View all →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Customer</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Movie</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Date</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-300">{{ $booking->user->name }}</td>
                            <td class="px-5 py-3 text-gray-300">{{ $booking->showtime->movie->title }}</td>
                            <td class="px-5 py-3 text-gray-400">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $booking->status === 'confirmed' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-500">No bookings yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection