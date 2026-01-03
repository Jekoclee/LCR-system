@extends('layouts.app')

@section('title', 'Facilities | LCR Booking')

@section('content')
    <div class="pt-20 bg-[#0a1128] min-h-screen">
        <!-- Hero Section -->
        <div
            class="relative h-[40vh] min-h-[300px] flex items-center justify-center overflow-hidden border-b border-blue-900/30">
            <div class="absolute inset-0 z-0">
                @if(file_exists(public_path('images/homepage/facilities.jpg')))
                    <img src="{{ asset('images/homepage/facilities.jpg') }}" alt="Facilities Header"
                        class="w-full h-full object-cover opacity-40">
                @else
                    <img src="{{ asset('lcr.jpeg') }}" alt="Facilities Header" class="w-full h-full object-cover opacity-40">
                @endif
                <div class="absolute inset-0 bg-gradient-to-b from-[#0a1128]/60 via-[#0a1128]/80 to-[#0a1128]"></div>
            </div>

            <div class="relative z-10 text-center px-6 reveal-up">
                <p class="text-blue-400 text-xs tracking-[0.4em] uppercase mb-4 font-bold">LCR AMENITIES</p>
                <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tighter text-white">Our Facilities</h1>
                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-24">
            <p class="text-xl text-gray-300 mb-16 max-w-3xl mx-auto text-center reveal-up">Experience world-class amenities
                designed for your comfort and relaxation.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Facility Item -->
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden group hover:border-blue-500/50 hover:bg-blue-900/20 transition-all duration-300 reveal-up"
                    style="--delay: 100ms">
                    <div class="h-64 bg-gray-800 relative overflow-hidden">
                        <img src="{{ asset('pool.jpg') }}" alt="Swimming Pool"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-3 text-white">Infinity Pool</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">Take a dip in our temperature-controlled infinity
                            pool with a stunning view of the skyline.</p>
                    </div>
                </div>

                <!-- Facility Item -->
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden group hover:border-blue-500/50 hover:bg-blue-900/20 transition-all duration-300 reveal-up"
                    style="--delay: 200ms">
                    <div class="h-64 bg-gray-800 relative overflow-hidden group-hover:bg-blue-900/20 transition-colors">
                        <div
                            class="absolute inset-0 flex items-center justify-center text-gray-600 group-hover:text-blue-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-3 text-white">Fitness Center</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">Stay fit during your stay with our state-of-the-art
                            gym equipment and professional trainers.</p>
                    </div>
                </div>

                <!-- Facility Item -->
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden group hover:border-blue-500/50 hover:bg-blue-900/20 transition-all duration-300 reveal-up"
                    style="--delay: 300ms">
                    <div class="h-64 bg-gray-800 relative overflow-hidden group-hover:bg-blue-900/20 transition-colors">
                        <div
                            class="absolute inset-0 flex items-center justify-center text-gray-600 group-hover:text-blue-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-3 text-white">Spa & Wellness</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">Relax and rejuvenate your body and soul with our
                            premium spa treatments and massage therapies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection