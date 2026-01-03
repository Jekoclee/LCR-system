@extends('layouts.app')

@section('title', 'Events | LCR Booking')

@section('content')
    <div class="pt-24 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-8 tracking-tight">Events & Celebrations</h1>
            <p class="text-xl text-gray-300 mb-12 max-w-3xl">From corporate meetings to dream weddings, we provide the perfect venue for your most memorable moments.</p>
            
            <div class="space-y-12">
                <!-- Event Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="h-[400px] bg-gray-800 rounded-3xl overflow-hidden relative shadow-2xl group">
                        <img src="{{ asset('lcr.jpeg') }}" alt="Weddings" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    </div>
                    <div class="space-y-6">
                        <span class="text-blue-400 font-bold tracking-widest uppercase text-xs">Unforgettable Moments</span>
                        <h2 class="text-3xl md:text-4xl font-bold tracking-tight">Dream Weddings</h2>
                        <p class="text-gray-400 text-lg">Celebrate your love in a setting as beautiful as your story. Our grand ballroom and garden venues provide the perfect backdrop for your special day.</p>
                        <ul class="space-y-3 text-gray-300">
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Custom catering packages
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Professional event planning
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Luxury suite for the couple
                            </li>
                        </ul>
                        <a href="{{ route('contact') }}" class="inline-block bg-white text-black px-8 py-3 rounded-full font-bold hover:bg-gray-200 transition-colors">Inquire Now</a>
                    </div>
                </div>

                <!-- Event Section (Reversed) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center lg:flex-row-reverse">
                    <div class="lg:order-2 h-[400px] bg-gray-800 rounded-3xl overflow-hidden relative shadow-2xl group">
                        <div class="absolute inset-0 flex items-center justify-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <span class="text-blue-400 font-bold tracking-widest uppercase text-xs">Professional Excellence</span>
                        <h2 class="text-3xl md:text-4xl font-bold tracking-tight">Corporate Meetings</h2>
                        <p class="text-gray-400 text-lg">Inspire your team in our modern meeting rooms equipped with the latest audio-visual technology and high-speed internet.</p>
                        <ul class="space-y-3 text-gray-300">
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                High-speed Wi-Fi
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Modern AV equipment
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Business center services
                            </li>
                        </ul>
                        <a href="{{ route('contact') }}" class="inline-block bg-white text-black px-8 py-3 rounded-full font-bold hover:bg-gray-200 transition-colors">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
