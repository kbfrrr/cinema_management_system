<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-30 bg-gray-900/90 backdrop-blur border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

            <a href="{{ route('customer.home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1
                               1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                </div>
                <span class="font-bold text-white text-sm">CineBook</span>
            </a>

            <div class="flex items-center gap-3">
                @if(session('user_id'))
                    <a href="{{ route('customer.bookings') }}"
                        class="text-sm text-gray-400 hover:text-white transition">My Bookings</a>
                    <div class="flex items-center gap-2 pl-3 border-l border-gray-700">
                        <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}
                        </div>
                        <span class="text-sm text-gray-300">{{ session('user_name') }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="ml-1">
                            @csrf
                            <button type="submit" class="text-xs text-gray-500 hover:text-red-400 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-400 hover:text-white transition">Sign in</a>
                    <a href="{{ route('register') }}"
                        class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium
                               px-4 py-1.5 rounded-lg transition">
                        Register
                    </a>
                @endif
            </div>

        </div>
    </nav>

    {{-- Page content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-800 py-6 mt-10">
        <p class="text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} CineBook. All rights reserved.
        </p>
    </footer>

</body>
</html>