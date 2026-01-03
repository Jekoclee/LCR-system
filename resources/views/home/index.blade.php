@extends('layouts.app')

@section('title', 'LCR Booking | Hotel Booking')

@section('content')
    <header id="header" class="relative h-screen pt-24 md:pt-28 flex items-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            @if(file_exists(public_path('images/homepage/pool.jpg')))
                <img src="{{ asset('images/homepage/pool.jpg') }}" alt="Pool Area" class="w-full h-full object-cover">
            @elseif(file_exists(public_path('images/homepage/hero-user.jpg')))
                <img src="{{ asset('images/homepage/hero-user.jpg') }}" alt="Header" class="w-full h-full object-cover">
            @elseif(file_exists(public_path('images/homepage/lcr.jpeg')))
                <img src="{{ asset('images/homepage/lcr.jpeg') }}" alt="Header" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('lcr.jpeg') }}" alt="Header" class="w-full h-full object-cover">
            @endif
            <!-- Gradient Overlay: Blue tone for readability -->
            <div class="absolute inset-0 bg-gradient-to-tr from-[#0a1128]/60 via-[#0a1128]/30 to-black/60"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 flex justify-end">
            <div class="max-w-xl text-right md:text-left reveal-up">
                <p class="text-xs tracking-[0.3em] text-gray-400 uppercase mb-4 font-medium">LCR HOTEL & RESORT</p>
                <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-8 leading-tight text-white">
                    Slide into your <br />
                    most stylish <br />
                    staycation.
                </h1>
                <div class="flex justify-end md:justify-start">
                    <a href="{{ route('rooms') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 text-sm font-bold tracking-widest transition-all duration-300 uppercase shadow-lg shadow-blue-900/40">
                        Find Out More
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Form Floating at Bottom -->
        <div class="absolute bottom-10 left-0 right-0 z-20 px-4">
            <div class="bg-black/40 backdrop-blur-xl border border-white/10 p-4 rounded-2xl max-w-5xl mx-auto shadow-2xl reveal-up" style="--delay: 150ms">
                <form method="POST" action="{{ route('hotels.search') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @csrf
                    <div class="relative">
                        <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Destination"
                            class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <div class="relative">
                        <input type="date" name="check_in" value="{{ old('check_in') }}" placeholder="Check-in"
                            class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <div class="relative">
                        <input type="date" name="check_out" value="{{ old('check_out') }}" placeholder="Check-out"
                            class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <div class="relative">
                        <input type="number" name="guests" value="{{ old('guests') }}" placeholder="Guests" min="1"
                            class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors" />
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg shadow-blue-900/40">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Rooms & Suites Section -->
    <section class="py-24 bg-[#0a1128]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative p-2 md:p-4 border border-blue-900/30 reveal-up">
                <div class="flex flex-col md:flex-row min-h-[500px]">
                    <!-- Image Area -->
                    <div class="w-full md:w-1/2 relative overflow-hidden reveal-left" style="--delay: 100ms">
                        @if(file_exists(public_path('images/homepage/lcr.jpeg')))
                            <img src="{{ asset('images/homepage/lcr.jpeg') }}" alt="Superior Twin" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('lcr.jpeg') }}" alt="Superior Twin" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-blue-900/10"></div>
                    </div>

                    <!-- Content Area -->
                    <div class="w-full md:w-1/2 bg-[#0c1633] p-12 md:p-20 flex flex-col justify-center relative overflow-hidden reveal-right" style="--delay: 200ms">
                        <!-- Wave Pattern Overlay -->
                        <div class="absolute inset-0 opacity-[0.05] pointer-events-none bg-white/5"></div>
                        
                        <div class="relative z-10">
                            <p class="text-[10px] tracking-[0.4em] text-blue-400 uppercase font-bold mb-4">ROOMS & SUITES</p>
                            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 tracking-tight">Superior Twin</h2>
                            <p class="text-blue-100/70 leading-relaxed mb-8 max-w-md">
                                The Superior Twin Room measured at 28sqm, has room configuration of 2 twin beds and features a work area and lounge chair. It can accommodate up to 3 guests.
                            </p>
                            
                            <a href="{{ route('rooms') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 text-xs font-bold tracking-widest transition-all duration-300 uppercase shadow-lg shadow-blue-900/40 reveal-up" style="--delay: 320ms">
                                CHECK AVAILABILITY
                            </a>
                        </div>

                        <!-- Navigation Arrows -->
                        <div class="absolute bottom-8 right-8 flex gap-2">
                            <button class="w-10 h-10 border border-white/10 flex items-center justify-center hover:bg-blue-600 text-white transition-all group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button class="w-10 h-10 border border-white/10 flex items-center justify-center hover:bg-blue-600 text-white transition-all group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-[#0c1633]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 reveal-right">
                    <p class="text-[10px] tracking-[0.4em] text-blue-400 uppercase font-bold">OUR DINING</p>
                    <h2 class="text-5xl font-bold text-white tracking-tight">Sabina Restaurant</h2>
                    <p class="text-blue-100/70 max-w-xl">Satisfy your cravings with dining options from simple snacks to filling meals for an exciting day ahead.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto place-items-center">
                        <div class="bg-white/5 border border-white/10 rounded-xl p-6 reveal-up w-full sm:w-[320px] mx-auto" style="--delay: 120ms">
                            <h3 class="font-bold text-lg text-white">Strike a balance between work and leisure.</h3>
                            <a href="{{ route('dining.sabina') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow-lg shadow-blue-900/40">Explore Now</a>
                        </div>
                        <div class="rounded-xl overflow-hidden border border-white/10 reveal-up w-full sm:w-[320px] mx-auto" style="--delay: 220ms">
                            <div class="relative aspect-[4/3]">
                                @if(file_exists(public_path('images/dining/sabina.jpg')))
                                    <img src="{{ asset('images/dining/sabina.jpg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                                @elseif(file_exists(public_path('images/dining/sabina.jpeg')))
                                    <img src="{{ asset('images/dining/sabina.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                                @elseif(file_exists(public_path('images/dining/lcr.jpeg')))
                                    <img src="{{ asset('images/dining/lcr.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/homepage/lcr.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                                @endif
                                <div class="absolute inset-6 border-2 border-white rounded"></div>
                            </div>
                            <div class="p-6 bg-[#0a1128]">
                                <h4 class="font-bold text-lg text-white">Plan your next event with us.</h4>
                                <p class="text-blue-100/70 text-sm">We are a pet-friendly resort</p>
                                <a href="{{ route('events') }}" class="mt-4 inline-block bg-white text-black px-5 py-2 rounded-lg font-semibold hover:bg-gray-200">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('dining.sabina') }}" class="inline-flex items-center gap-2 bg-[#ff7a00] hover:bg-[#e56a00] text-white px-7 py-3 rounded-full font-bold shadow-lg reveal-up" style="--delay: 340ms">
                        Find Out More
                    </a>
                </div>
                <div>
                    <div class="relative rounded-lg overflow-hidden reveal-left" style="--delay: 140ms">
                        @if(file_exists(public_path('images/dining/sabina.jpg')))
                            <img src="{{ asset('images/dining/sabina.jpg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                        @elseif(file_exists(public_path('images/dining/sabina.jpeg')))
                            <img src="{{ asset('images/dining/sabina.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                        @elseif(file_exists(public_path('images/dining/lcr.jpeg')))
                            <img src="{{ asset('images/dining/lcr.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/homepage/lcr.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-6 border-2 border-white rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session('status'))
        <div class="fixed bottom-10 right-10 z-[70] bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl animate-bounce">
            {{ session('status') }}
        </div>
    @endif
@endsection
