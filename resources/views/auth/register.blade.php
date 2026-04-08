<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema — Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1
                           1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Create an account</h1>
            <p class="text-gray-400 text-sm mt-1">Start booking your movies today</p>
        </div>

        <div class="bg-gray-900 rounded-2xl shadow-xl p-8 border border-gray-800">

            @if(session('error'))
                <div class="mb-6 flex items-start gap-3 bg-red-500/10 border border-red-500/30
                            text-red-400 text-sm rounded-lg px-4 py-3">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-4.75a.75.75
                            0 001.5 0v-4.5a.75.75 0 00-1.5 0v4.5zm.75-7a.75.75 0 100 1.5.75.75 0 000-1.5z"
                            clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                               rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-transparent transition
                               @error('name') border-red-500 @enderror"/>
                    @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                               rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-transparent transition
                               @error('email') border-red-500 @enderror"/>
                    @error('email') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                                   rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                                   focus:ring-blue-500 focus:border-transparent transition
                                   @error('password') border-red-500 @enderror"/>
                        @error('password') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Confirm</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                                   rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2
                                   focus:ring-blue-500 focus:border-transparent transition"/>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg
                           py-2.5 text-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:ring-offset-2 focus:ring-offset-gray-900 mt-2">
                    Create Account
                </button>

            </form>

            <p class="text-center text-gray-400 text-sm mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition">Sign in</a>
            </p>

        </div>

        <p class="text-center text-gray-500 text-xs mt-6">
            &copy; {{ date('Y') }} Cinema Management System
        </p>

    </div>

</body>
</html>