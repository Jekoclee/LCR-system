<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LCR Booking | Hotel Booking')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-blue-900 text-white antialiased font-sans scroll-smooth">
    <!-- Navigation -->
    <nav class="fixed w-full z-[60] bg-gray-900/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}"
                class="text-2xl font-bold tracking-tighter bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                LCR BOOKING
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-200">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                <a href="{{ route('rooms') }}" class="hover:text-white transition-colors">Rooms</a>
                <a href="{{ route('facilities') }}" class="hover:text-white transition-colors">Facilities</a>
                <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a>

                <!-- Dining Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-1 hover:text-white transition-colors py-2">
                        Dining
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 mt-0 w-48 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block border border-gray-100">
                        <a href="{{ route('dining.sabina') }}"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-800 hover:bg-gray-50 transition-colors">
                            <span class="inline-block w-2 h-2 rounded-full border border-gray-400"></span>
                            Sabina Restaurant
                        </a>
                    </div>
                </div>

                <a href="{{ route('events') }}" class="hover:text-white transition-colors">Events</a>
            </div>

            <div class="flex items-center gap-3">
                @guest
                    <button data-open-login-modal
                        class="hidden sm:block px-4 py-2 rounded-full text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-colors">Sign
                        In</button>
                    <a href="{{ route('register') }}"
                        class="hidden sm:block px-4 py-2 rounded-full text-sm font-semibold border border-white/20 text-white hover:bg-white/10 transition-colors">Register</a>
                @endguest
                @auth
                    <div class="relative">
                        <button id="user-menu-button"
                            class="flex items-center gap-2 px-3 py-2 rounded-full border border-white/20 text-white hover:bg-white/10 transition-all">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ asset('uploads/profile/' . auth()->user()->profile_picture) }}"
                                    class="h-6 w-6 rounded-full object-cover border border-white/20">
                            @elseif(file_exists(public_path('user-profile.jpg')))
                                <img src="{{ asset('user-profile.jpg') }}"
                                    class="h-6 w-6 rounded-full object-cover border border-white/20">
                            @else
                                <span
                                    class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-[10px] font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @endif
                            <span class="text-sm font-semibold hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="user-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-gray-900 border border-white/10 rounded-xl shadow-xl z-50 overflow-hidden">
                            @if(auth()->user()->isAdminOrAbove())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-3 text-sm text-amber-300 hover:bg-white/10 transition-colors font-semibold">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Admin Panel
                                </a>
                            @endif
                            <a href="{{ route('bookings') }}"
                                class="block px-4 py-3 text-sm text-gray-200 hover:bg-white/10 transition-colors">My
                                Booking</a>
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-3 text-sm text-gray-200 hover:bg-white/10 transition-colors">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-3 text-sm text-gray-200 hover:bg-white/10 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="menu-button"
                    class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-white/10 bg-gray-900/95 backdrop-blur-lg">
            <div class="px-6 py-4 space-y-4 text-sm font-medium text-gray-200">
                <a href="{{ url('/') }}" class="block hover:text-white transition-colors">Home</a>
                <a href="{{ route('rooms') }}" class="block hover:text-white transition-colors">Rooms</a>
                <a href="{{ route('facilities') }}" class="block hover:text-white transition-colors">Facilities</a>
                <a href="{{ route('contact') }}" class="block hover:text-white transition-colors">Contact Us</a>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-widest text-gray-500 font-bold">Dining</p>
                    <a href="{{ route('dining.sabina') }}"
                        class="block pl-4 hover:text-white transition-colors text-sm">Sabina Restaurant</a>
                </div>
                <a href="{{ route('events') }}" class="block hover:text-white transition-colors">Events</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <div id="login-modal" class="fixed inset-0 z-[80] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md" data-close-login-modal="true"></div>
        <div
            class="relative w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Sign In</h2>
                <button class="p-2 rounded hover:bg-white/10" data-close-login-modal="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-300 bg-red-600/20 border border-red-500/30 px-3 py-2 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Email or Name</label>
                    <input type="text" name="login" value="{{ old('login') }}"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                        placeholder="you@example.com" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                        placeholder="••••••••" required>
                </div>
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-300">
                        <input type="checkbox" name="remember" class="rounded bg-black/40 border-white/20">
                        Remember me
                    </label>
                    <a href="{{ route('register') }}" class="text-blue-300 hover:text-blue-200 text-sm">Create
                        account</a>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-900/40">Sign
                    In</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-gray-800 py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-start">
                <div class="space-y-4">
                    <h2 class="text-3xl font-serif font-bold text-gray-900">LCR</h2>
                    <p class="text-sm text-gray-600 font-medium">
                        © 2025 LEISURE COAST RESORT. All rights reserved.
                    </p>
                </div>
                <div class="space-y-4 md:pl-12">
                    <a href="#" class="block text-gray-800 hover:text-blue-600 font-semibold transition-colors">Privacy
                        Policy</a>
                    <a href="#" class="block text-gray-800 hover:text-blue-600 font-semibold transition-colors">Terms and Conditions</a>
                    <a href="{{ route('rules') }}" class="block text-gray-800 hover:text-blue-600 font-semibold transition-colors">Rules &amp; Regulations</a>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900">Follow here</h3>
                    <a href="#"
                        class="flex items-center gap-2 text-gray-800 hover:text-blue-600 font-semibold transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        Facebook
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <div id="rules-modal" class="fixed inset-0 z-[80] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md" data-close-rules-modal="true"></div>
        <div class="relative w-full max-w-3xl bg-white/10 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Rules & Regulations</h2>
                <button class="p-2 rounded hover:bg-white/10" data-close-rules-modal="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @php
                $rulesImgPath = null;
                foreach (['rules.jpg','rules.png','rules.webp'] as $f) {
                    $p = public_path('images/'.$f);
                    if (file_exists($p)) {
                        $rulesImgPath = asset('images/'.$f).'?v='.@filemtime($p);
                        break;
                    }
                }
            @endphp
            <div class="rounded-xl overflow-hidden border border-white/10">
                @if($rulesImgPath)
                    <img src="{{ $rulesImgPath }}" class="w-full h-auto max-h-[75vh] object-contain">
                @else
                    <div class="p-6 text-sm text-gray-200">Walang na-upload na Rules & Regulations image. Ilagay ang file sa public/images/rules.jpg</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Floating Contact Button -->
    <a href="{{ route('contact') }}"
        class="fixed bottom-8 right-8 z-[70] bg-blue-900 text-white p-4 rounded-full shadow-2xl hover:bg-blue-800 transition-all group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
        </svg>
        <span
            class="absolute right-full mr-3 bg-blue-900 text-white px-3 py-1 rounded text-xs font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">Contact
            Us</span>
    </a>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // User Menu Toggle
            const userBtn = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            if (userBtn && userMenu) {
                userBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });
            }

            // Mobile Menu Toggle
            const menuBtn = document.getElementById('menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Close menus on click outside
            document.addEventListener('click', function () {
                if (userMenu) userMenu.classList.add('hidden');
            });

            const loginModal = document.getElementById('login-modal');
            const openers = document.querySelectorAll('[data-open-login-modal]');
            const closers = document.querySelectorAll('[data-close-login-modal]');
            const rulesModal = document.getElementById('rules-modal');
            const rulesOpeners = document.querySelectorAll('[data-open-rules-modal]');
            const rulesClosers = document.querySelectorAll('[data-close-rules-modal]');
            function openLogin() {
                if (!loginModal) return;
                loginModal.classList.remove('hidden');
                loginModal.classList.add('flex');
            }
            function closeLogin() {
                if (!loginModal) return;
                loginModal.classList.add('hidden');
                loginModal.classList.remove('flex');
            }
            function openRules() {
                if (!rulesModal) return;
                rulesModal.classList.remove('hidden');
                rulesModal.classList.add('flex');
            }
            function closeRules() {
                if (!rulesModal) return;
                rulesModal.classList.add('hidden');
                rulesModal.classList.remove('flex');
            }
            openers.forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    openLogin();
                });
            });
            closers.forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    closeLogin();
                });
            });
            rulesOpeners.forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    openRules();
                });
            });
            rulesClosers.forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    closeRules();
                });
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeLogin();
                    closeRules();
                }
            });
            @if($errors->any())
                openLogin();
            @endif
        });
    </script>
    @yield('scripts')
</body>

</html>
