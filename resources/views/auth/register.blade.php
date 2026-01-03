<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account | LCR Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-[#0a1128] text-white antialiased font-sans flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute top-40 -left-20 w-72 h-72 bg-blue-900/20 rounded-full blur-[80px]"></div>
    </div>

    <div class="w-full max-w-lg px-6 relative z-10">
        <!-- Logo/Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold tracking-tight mb-2">Create Account</h1>
            <p class="text-blue-200/60">Join us to start booking your perfect stay</p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
            @if ($errors->any())
                <div
                    class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="font-bold block mb-1">Registration Failed</span>
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-300 ml-1">Full Name</label>
                    <div class="relative">
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3.5 pl-11 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium"
                            placeholder="John Doe" required>
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-300 ml-1">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3.5 pl-11 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium"
                            placeholder="you@gmail.com" required>
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    @if ($errors->has('email'))
                        <p class="text-xs text-red-400 mt-1 ml-1">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-300 ml-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password"
                                class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3.5 pl-11 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium"
                                placeholder="••••••••" required>
                            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-300 ml-1">Confirm</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation"
                                class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3.5 pl-11 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium"
                                placeholder="••••••••" required>
                            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-900/40 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Create Account
                    </button>
                </div>

                <p class="text-center text-gray-400 text-sm mt-6">
                    Already have an account?
                    <a href="{{ route('home') }}"
                        onclick="event.preventDefault(); document.getElementById('login-trigger').click();"
                        class="text-blue-400 hover:text-blue-300 font-bold transition-colors">Sign In</a>
                    <button id="login-trigger" class="hidden" data-open-login-modal></button>
                </p>
            </form>
        </div>

        <p class="text-center text-gray-500 text-xs mt-8">
            &copy; {{ date('Y') }} LCR Booking System. All rights reserved.
        </p>
    </div>

    <!-- Script to handle login modal trigger if on separate page -->
    <script>
        document.getElementById('login-trigger').addEventListener('click', function () {
            window.location.href = "{{ route('home') }}?action=login";
        });
    </script>
</body>

</html>
