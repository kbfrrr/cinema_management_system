@extends('admin.layouts.app')
@section('title', 'Bookings')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">All Bookings</h2>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.bookings.index') }}"
        class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search customer..."
            class="bg-gray-800 border border-gray-700 text-white placeholder-gray-500 rounded-lg
                   px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition w-56"/>
        <select name="status"
            class="bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <option value="">All statuses</option>
            <option value="confirmed"  {{ request('status') === 'confirmed'  ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-500 text-white text-sm px-4 py-2 rounded-lg transition">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.bookings.index') }}"
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
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Customer</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Movie</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Cinema / Hall</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Showtime</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Payment</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Status</th>
                        <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $booking->booking_id }}</td>

                            <td class="px-5 py-3">
                                <p class="text-white font-medium">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->user->email }}</p>
                            </td>

                            <td class="px-5 py-3 text-gray-300">
                                {{ $booking->showtime->movie->title }}
                            </td>

                            <td class="px-5 py-3">
                                <p class="text-gray-300">{{ $booking->showtime->hall->cinema->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->showtime->hall->hall_name }}</p>
                            </td>

                            <td class="px-5 py-3 text-gray-400 text-xs">
                                {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('M d, Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('g:i A') }}
                            </td>

                            <td class="px-5 py-3">
                                @if($booking->payment)
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $booking->payment->payment_status === 'paid'
                                            ? 'bg-green-500/10 text-green-400'
                                            : ($booking->payment->payment_status === 'pending'
                                                ? 'bg-amber-500/10 text-amber-400'
                                                : 'bg-red-500/10 text-red-400') }}">
                                        {{ ucfirst($booking->payment->payment_status) }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">
                                        ₱{{ number_format($booking->payment->amount, 2) }}
                                    </p>
                                @else
                                    <span class="text-xs text-gray-500">No payment</span>
                                @endif
                            </td>

                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $booking->status === 'confirmed'
                                        ? 'bg-green-500/10 text-green-400'
                                        : 'bg-red-500/10 text-red-400' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <td class="px-5 py-3">
                                <form method="POST"
                                    action="{{ route('admin.bookings.status', $booking->booking_id) }}">
                                    @csrf @method('PATCH')
                                    @if($booking->status === 'confirmed')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit"
                                            onclick="return confirm('Cancel this booking?')"
                                            class="px-3 py-1 bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs rounded-lg transition">
                                            Cancel
                                        </button>
                                    @else
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-500/10 hover:bg-green-500/20 text-green-400 text-xs rounded-lg transition">
                                            Restore
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-gray-500">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="px-5 py-4 border-t border-gray-800">{{ $bookings->links() }}</div>
        @endif
    </div>

@endsection