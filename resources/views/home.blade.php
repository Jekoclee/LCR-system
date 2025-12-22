<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LCR Booking | Hotel Booking</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-900 text-white antialiased font-sans scroll-smooth">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-gray-900/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold tracking-tighter bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                LCR BOOKING
            </div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-200">
                <a href="#header" class="hover:text-white transition-colors">Home</a>
                <a href="#rooms" class="hover:text-white transition-colors">Rooms</a>
                <a href="#amenities" class="hover:text-white transition-colors">Amenities</a>
                <a href="#contact" class="hover:text-white transition-colors">Contact</a>
            </div>
            <div class="flex items-center gap-3">
                @guest
                <a href="{{ route('login') }}" class="bg-white text-black px-6 py-2 rounded-full text-sm font-semibold hover:bg-gray-200 transition-colors">Sign In</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-full text-sm font-semibold border border-white/20 text-white hover:bg-white/10 transition-colors">Register</a>
                @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white text-black px-6 py-2 rounded-full text-sm font-semibold hover:bg-gray-200 transition-colors">Logout</button>
                </form>
                @endguest
                <button id="menu-button" class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden border-t border-white/10 bg-gray-900/90">
            <div class="px-6 py-4 space-y-3 text-sm font-medium text-gray-200">
                <a href="#header" class="block hover:text-white transition-colors">Home</a>
                <a href="#rooms" class="block hover:text-white transition-colors">Rooms</a>
                <a href="#amenities" class="block hover:text-white transition-colors">Amenities</a>
                <a href="#contact" class="block hover:text-white transition-colors">Contact</a>
            </div>
        </div>
    </nav>

    <header id="header" class="relative h-[50vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('lcr.jpeg') }}" alt="Header" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-blue-900/70 via-blue-800/50 to-blue-900"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto mt-20">
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 leading-tight">
                Find Your Perfect <br />
                <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Hotel Stay</span>
            </h1>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto font-light">
                Discover handpicked hotels and resorts with world-class amenities and comfort.
            </p>
            @if (session('status'))
            <div class="mb-6 max-w-2xl mx-auto bg-emerald-600/20 text-emerald-300 border border-emerald-500/30 px-4 py-3 rounded-xl">
                {{ session('status') }}
            </div>
            @endif

            <div
                class="bg-white/10 backdrop-blur-xl border border-white/10 p-4 rounded-2xl max-w-5xl mx-auto shadow-2xl">
                <form method="POST" action="{{ route('hotels.search') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @csrf
                    <div class="relative">
                        <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Destination"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <div class="relative">
                        <input type="date" name="check_in" value="{{ old('check_in') }}" placeholder="Check-in"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <div class="relative">
                        <input type="date" name="check_out" value="{{ old('check_out') }}" placeholder="Check-out"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <div class="relative">
                        <input type="number" min="1" name="guests" value="{{ old('guests', 1) }}" placeholder="Guests"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all transform hover:scale-[1.02]">
                        Search Rooms
                    </button>
                </form>
            </div>
        </div>
    </header>

    <section id="rooms" class="py-24 bg-blue-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Featured Hotels</h2>
                    <p class="text-gray-400">Curated stays for every occasion</p>
                </div>
                <a href="#" class="text-blue-400 hover:text-blue-300 flex items-center gap-2 text-sm font-medium group">
                    View All
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="group relative bg-gray-900 rounded-3xl overflow-hidden border border-white/5 hover:border-white/20 transition-all duration-300">
                    <div class="aspect-[4/3] bg-gray-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent z-10 opactiy-50">
                        </div>
                        <div class="w-full h-full flex items-center justify-center text-gray-700 font-bold text-2xl">
                            CITY HOTEL
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                        <h3 class="text-xl font-bold mb-1">Grand Palace Hotel</h3>
                        <p class="text-gray-400 text-sm mb-4">Starting at $120/night</p>
                        <button
                            class="w-full bg-white/10 hover:bg-white text-white hover:text-black py-2 rounded-lg text-sm font-semibold transition-colors backdrop-blur-sm">
                            View Details
                        </button>
                    </div>
                </div>

                <div
                    class="group relative bg-gray-900 rounded-3xl overflow-hidden border border-white/5 hover:border-white/20 transition-all duration-300">
                    <div class="aspect-[4/3] bg-gray-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent z-10 opactiy-50">
                        </div>
                        <div class="w-full h-full flex items-center justify-center text-gray-700 font-bold text-2xl">
                            BEACH RESORT
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                        <h3 class="text-xl font-bold mb-1">Seaside Resort</h3>
                        <p class="text-gray-400 text-sm mb-4">Starting at $180/night</p>
                        <button
                            class="w-full bg-white/10 hover:bg-white text-white hover:text-black py-2 rounded-lg text-sm font-semibold transition-colors backdrop-blur-sm">
                            View Details
                        </button>
                    </div>
                </div>

                <div
                    class="group relative bg-gray-900 rounded-3xl overflow-hidden border border-white/5 hover:border-white/20 transition-all duration-300">
                    <div class="aspect-[4/3] bg-gray-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent z-10 opactiy-50">
                        </div>
                        <div class="w-full h-full flex items-center justify-center text-gray-700 font-bold text-2xl">
                            BOUTIQUE
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                        <h3 class="text-xl font-bold mb-1">City Lights Boutique</h3>
                        <p class="text-gray-400 text-sm mb-4">Starting at $150/night</p>
                        <button
                            class="w-full bg-white/10 hover:bg-white text-white hover:text-black py-2 rounded-lg text-sm font-semibold transition-colors backdrop-blur-sm">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="amenities" class="py-24 bg-blue-950/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center p-6">
                <div
                    class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-blue-500 text-2xl">
                    ★
                </div>
                <h3 class="text-xl font-bold mb-3">24/7 Support</h3>
                <p class="text-gray-400 leading-relaxed">Round-the-clock assistance for bookings and special requests.</p>
            </div>
            <div class="text-center p-6">
                <div
                    class="w-16 h-16 bg-purple-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-purple-500 text-2xl">
                    ∞
                </div>
                <h3 class="text-xl font-bold mb-3">Flexible Cancellation</h3>
                <p class="text-gray-400 leading-relaxed">Enjoy flexible policies on selected hotel stays.</p>
            </div>
            <div class="text-center p-6">
                <div
                    class="w-16 h-16 bg-emerald-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-emerald-500 text-2xl">
                    🛡
                </div>
                <h3 class="text-xl font-bold mb-3">Best Price Guarantee</h3>
                <p class="text-gray-400 leading-relaxed">Get competitive rates across our trusted hotel partners.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-blue-900 border-t border-white/10 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <div class="text-2xl font-bold tracking-tighter text-white mb-6">
                        LCR BOOKING
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Setting the standard for luxury car rentals. Experience excellence in every mile.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Company</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Support</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Newsletter</h4>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Email address"
                            class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white w-full focus:outline-none focus:border-white/30" />
                        <button
                            class="bg-white text-black px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition-colors">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>&copy; 2025 LCR Booking. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Twitter</a>
                    <a href="#" class="hover:text-white transition-colors">Instagram</a>
                    <a href="#" class="hover:text-white transition-colors">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>
    <script>
        const btn = document.getElementById('menu-button');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    </script>
</body>

</html>