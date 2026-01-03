@extends('layouts.app')

@section('title', 'Our Rooms | LCR Booking')

@section('content')
    <div class="pt-20 bg-[#0a1128] min-h-screen">
        <!-- Hero Section -->
        <div
            class="relative h-[40vh] min-h-[300px] flex items-center justify-center overflow-hidden border-b border-blue-900/30">
            <div class="absolute inset-0 z-0">
                @if(file_exists(public_path('images/homepage/lcr.jpeg')))
                    <img src="{{ asset('images/homepage/lcr.jpeg') }}" alt="Rooms Header"
                        class="w-full h-full object-cover opacity-40">
                @else
                    <img src="{{ asset('lcr.jpeg') }}" alt="Rooms Header" class="w-full h-full object-cover opacity-40">
                @endif
                <div class="absolute inset-0 bg-gradient-to-b from-[#0a1128]/60 via-[#0a1128]/80 to-[#0a1128]"></div>
            </div>

            <div class="relative z-10 text-center px-6 reveal-up">
                <p class="text-blue-400 text-xs tracking-[0.4em] uppercase mb-4 font-bold">LCR ACCOMMODATIONS</p>
                <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tighter text-white">Our Rooms</h1>
                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>
        </div>

        <!-- Rooms Section -->
        @if(isset($rooms) && count($rooms) > 0)
            <div class="max-w-7xl mx-auto px-6 py-24 space-y-20">
                @foreach ($rooms as $index => $room)
                    @php $reverse = $index % 2 === 1; @endphp
                    <div class="flex flex-col {{ $reverse ? 'lg:flex-row-reverse' : 'lg:flex-row' }} gap-12 lg:gap-20 items-center">
                        <div class="w-full lg:w-1/2 group {{ $reverse ? 'reveal-right' : 'reveal-left' }}" style="--delay: 100ms">
                            <div class="relative">
                                <div
                                    class="absolute {{ $reverse ? '-bottom-4 -right-4' : '-top-4 -left-4' }} w-full h-full border border-blue-900/30 rounded-lg z-0">
                                </div>
                                <div
                                    class="relative z-10 rounded-lg overflow-hidden border border-white/10 shadow-2xl shadow-blue-900/20">
                                    <img src="{{ $room['primary_img'] }}" alt="{{ $room['name'] }}"
                                        class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition-transform duration-700">
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 {{ $reverse ? 'reveal-left' : 'reveal-right' }}" style="--delay: 200ms">
                            <div class="flex items-center gap-4 mb-4">
                                <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">{{ $room['name'] }}</h2>
                                @if($room['rating_count'] > 0)
                                    <div
                                        class="flex items-center gap-1 bg-yellow-500/10 border border-yellow-500/30 px-3 py-1 rounded-full text-yellow-500 text-sm font-bold">
                                        ★ {{ number_format($room['rating_avg'], 1) }}
                                        <span class="text-xs text-gray-500 ml-1">({{ $room['rating_count'] }})</span>
                                    </div>
                                @endif
                            </div>
                            <p class="text-gray-400 leading-relaxed mb-8 text-lg">{{ $room['description'] }}</p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('book.start', ['room_id' => $room['id']]) }}"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 rounded-md text-sm tracking-widest uppercase transition-all shadow-lg shadow-blue-900/40">Check
                                    Availability</a>
                                <a href="{{ route('room.details', ['id' => $room['id']]) }}"
                                    class="inline-block border border-blue-600/50 hover:bg-blue-600/10 text-white font-bold px-10 py-4 rounded-md text-sm tracking-widest uppercase transition-all">Room
                                    Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="max-w-7xl mx-auto px-6 py-24 space-y-32">

                <!-- Superior King -->
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center">
                    <!-- Image Side -->
                    <div class="w-full lg:w-1/2 group reveal-left" style="--delay: 100ms">
                        <div class="relative">
                            <!-- Decorative frames from image -->
                            <div class="absolute -top-4 -left-4 w-full h-full border border-blue-900/30 rounded-lg z-0"></div>
                            <div
                                class="relative z-10 rounded-lg overflow-hidden border border-white/10 shadow-2xl shadow-blue-900/20">
                                <img src="{{ asset('lcr.jpeg') }}" alt="Superior King"
                                    class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition-transform duration-700">
                                <!-- Navigation arrows (UI only as per image) -->
                                <div class="absolute bottom-4 left-4 flex gap-2">
                                    <button class="bg-black/60 hover:bg-black/80 p-2 rounded text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button class="bg-black/60 hover:bg-black/80 p-2 rounded text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text Side -->
                    <div class="w-full lg:w-1/2 reveal-right" style="--delay: 200ms">
                        <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white tracking-tight">Superior King</h2>
                        <p class="text-gray-400 leading-relaxed mb-8 text-lg">
                            The Superior King Room measured at 28sqm, has room configuration of 1 king-sized bed and features a
                            work area and lounge chair. It can accommodate up to 3 guests.
                        </p>

                        <div class="mb-10">
                            <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                                Room Amenities
                                <span class="flex-grow h-px bg-white/10"></span>
                            </h4>
                            <ul class="grid grid-cols-2 gap-y-4 gap-x-8 text-gray-400 text-sm">
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Air conditioning
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    NDD / IDD
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Satellite / cable LED TV
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Private toilet
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Free LAN and Wi-Fi access
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Shower
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    In-room safe
                                </li>
                            </ul>
                        </div>

                        <a href="#"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 rounded-md text-sm tracking-widest uppercase transition-all shadow-lg shadow-blue-900/40">
                            Check Availability
                        </a>
                    </div>
                </div>

                <!-- Superior Twin (Alternating) -->
                <div class="flex flex-col lg:flex-row-reverse gap-12 lg:gap-20 items-center">
                    <!-- Image Side -->
                    <div class="w-full lg:w-1/2 group reveal-right" style="--delay: 100ms">
                        <div class="relative">
                            <div class="absolute -bottom-4 -right-4 w-full h-full border border-blue-900/30 rounded-lg z-0">
                            </div>
                            <div
                                class="relative z-10 rounded-lg overflow-hidden border border-white/10 shadow-2xl shadow-blue-900/20">
                                <img src="{{ asset('lcr.jpeg') }}" alt="Superior Twin"
                                    class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute bottom-4 left-4 flex gap-2">
                                    <button class="bg-black/60 hover:bg-black/80 p-2 rounded text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button class="bg-black/60 hover:bg-black/80 p-2 rounded text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text Side -->
                    <div class="w-full lg:w-1/2 reveal-left" style="--delay: 200ms">
                        <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white tracking-tight">Superior Twin</h2>
                        <p class="text-gray-400 leading-relaxed mb-8 text-lg">
                            The Superior Twin Room measured at 28sqm, has room configuration of 2 twin beds and features a work
                            area and lounge chair. It can accommodate up to 3 guests.
                        </p>

                        <div class="mb-10">
                            <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                                Room Amenities
                                <span class="flex-grow h-px bg-white/10"></span>
                            </h4>
                            <ul class="grid grid-cols-2 gap-y-4 gap-x-8 text-gray-400 text-sm">
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Air conditioning
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    NDD / IDD
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Satellite / cable LED TV
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Private toilet
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Free LAN and Wi-Fi access
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Shower
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    In-room safe
                                </li>
                            </ul>
                        </div>

                        <a href="#"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 rounded-md text-sm tracking-widest uppercase transition-all shadow-lg shadow-blue-900/40">
                            Check Availability
                        </a>
                    </div>
                </div>

            </div>
        @endif

        <!-- CTA Section -->
        <div class="bg-blue-950/20 border-t border-blue-900/30 py-24 text-center px-6">
            <h2 class="text-4xl font-bold mb-6 tracking-tight text-white reveal-up">Find your perfect space</h2>
            <p class="text-blue-200/60 mb-10 max-w-xl mx-auto reveal-up" style="--delay: 120ms">
                Experience the perfect blend of comfort and style. Book your stay today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center reveal-up" style="--delay: 240ms">
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white font-bold px-10 py-4 rounded-md hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/40 uppercase text-sm tracking-widest">
                    Create an Account
                </a>
                <a href="{{ route('contact') }}"
                    class="bg-transparent text-white border border-blue-500/30 font-bold px-10 py-4 rounded-md hover:bg-blue-500/10 transition-all uppercase text-sm tracking-widest">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
@endsection