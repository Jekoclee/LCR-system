@extends('layouts.app')

@section('title', 'Booking | LCR Booking')

@section('content')
    <!-- Main Container -->
    <div class="min-h-screen bg-gray-50 pt-24 pb-12 font-sans text-gray-800">

        <!-- Progress Bar -->
        <div class="max-w-7xl mx-auto mb-10 px-4">
            <div class="flex flex-wrap items-center justify-between text-center relative max-w-5xl mx-auto">
                <!-- Line -->
                <div class="absolute top-5 left-0 w-full h-1 bg-gray-200 -z-10 hidden md:block"></div>
                <div class="absolute top-5 left-0 h-1 bg-blue-600 -z-10 transition-all duration-500 hidden md:block"
                    id="progressLine" style="width: 0%"></div>

                <!-- Step 1 -->
                <div class="flex flex-col items-center gap-2 group cursor-default w-1/4">
                    <div id="p-step1"
                        class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg ring-4 ring-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Dates</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center gap-2 group cursor-default w-1/4">
                    <div id="p-step2"
                        class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold ring-4 ring-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Rooms</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center gap-2 group cursor-default w-1/4">
                    <div id="p-step3"
                        class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold ring-4 ring-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Guest</p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center gap-2 group cursor-default w-1/4">
                    <div id="p-step4"
                        class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold ring-4 ring-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Confirm</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Forms -->
            <div class="lg:col-span-2 space-y-6">

                @if(session('status'))
                    <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <p class="font-semibold">{{ session('status') }}</p>
                            @if(session('proof_url'))
                                <a href="{{ session('proof_url') }}" target="_blank"
                                    class="mt-1 inline-block text-sm underline hover:text-green-800">View payment proof</a>
                            @endif
                        </div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="bookingForm" method="POST" action="{{ route('book.submit') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Hidden Fields -->
                    <input type="hidden" name="room_id" id="room_id_hidden" value="{{ $booking['room_id'] ?? '' }}">
                    <input type="hidden" name="check_in" id="check_in_hidden" value="{{ $booking['check_in'] ?? '' }}">
                    <input type="hidden" name="check_out" id="check_out_hidden" value="{{ $booking['check_out'] ?? '' }}">
                    <input type="hidden" name="guests" id="guests_hidden" value="{{ $booking['guests'] ?? 1 }}">

                    <!-- Wrapper for Steps -->
                    <div
                        class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden relative min-h-[500px]">

                        <!-- Step 1: Dates (Check-in & Check-out) -->
                        <div id="step1" class="p-8 animate-fade-in-up">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                                Select Dates
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Check-in
                                        Date</label>
                                    <input type="date" id="check_in" value="{{ $booking['check_in'] ?? '' }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Check-out
                                        Date</label>
                                    <input type="date" id="check_out" value="{{ $booking['check_out'] ?? '' }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all font-semibold">
                                </div>
                            </div>

                            <div class="mb-8">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Number of Nights</label>
                                <div
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-500 font-medium">
                                    <span id="display_nights">0</span> night(s)
                                </div>
                            </div>

                            <!-- Interactive Calendar (Dual View) -->
                            <div id="calendar-container"
                                class="border border-gray-200 rounded-2xl p-6 mb-8 hidden md:block select-none">
                                <div class="flex items-center justify-between mb-6">
                                    <button type="button" id="prevMonth"
                                        class="p-2 hover:bg-gray-100 rounded-full text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="flex-1 grid grid-cols-2 gap-8 text-center">
                                        <h3 id="monthLabel1" class="text-lg font-bold text-gray-800"></h3>
                                        <h3 id="monthLabel2" class="text-lg font-bold text-gray-800"></h3>
                                    </div>
                                    <button type="button" id="nextMonth"
                                        class="p-2 hover:bg-gray-100 rounded-full text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-8 divide-x divide-gray-100">
                                    <!-- Left Calendar -->
                                    <div>
                                        <div class="grid grid-cols-7 text-center text-xs font-bold text-gray-400 mb-4">
                                            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                                        </div>
                                        <div id="calendarGrid1" class="grid grid-cols-7 gap-1"></div>
                                    </div>

                                    <!-- Right Calendar -->
                                    <div class="pl-8">
                                        <div class="grid grid-cols-7 text-center text-xs font-bold text-gray-400 mb-4">
                                            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                                        </div>
                                        <div id="calendarGrid2" class="grid grid-cols-7 gap-1"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" id="toStep2"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-orange-200 shadow-xl transition-all flex items-center gap-2">
                                    Continue
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Room Selection -->
                        <div id="step2" class="hidden p-8 animate-fade-in-up">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                                Select Room & Guests
                            </h2>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">PAX (Adult, Child,
                                        Extra Bed)</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <div>
                                            <input type="number" id="adults" name="adults" min="1" max="10"
                                                value="{{ $booking['guests'] ?? 1 }}"
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all">
                                            <p class="mt-1 text-xs text-gray-500">Adult</p>
                                        </div>
                                        <div>
                                            <input type="number" id="children" name="children" min="0" max="10"
                                                value="{{ old('children', 0) }}"
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all">
                                            <p class="mt-1 text-xs text-gray-500">Children</p>
                                        </div>
                                        <div>
                                            <input type="number" id="extra_pax" name="extra_pax" min="0" max="10"
                                                value="{{ old('extra_pax', 0) }}"
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all">
                                            <p class="mt-1 text-xs text-gray-500">Extra Pax 13 yrs old & above</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Select Room</label>
                                    @php $rid = (int) ($booking['room_id'] ?? 0); @endphp
                                    @if(!empty($rooms))
                                        <div id="room_grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($rooms as $r)
                                                <button type="button"
                                                    class="room-card w-full rounded-2xl border overflow-hidden text-left transition-all {{ $rid === (int) $r['id'] ? 'ring-2 ring-blue-500 border-blue-300' : 'border-gray-200 hover:border-blue-300 hover:shadow' }}"
                                                    data-room-id="{{ $r['id'] }}" {{ $rid === (int) $r['id'] ? 'data-selected=true' : '' }}>
                                                    <div class="aspect-[4/3] bg-gray-100 overflow-hidden">
                                                        <img src="{{ $r['img'] }}" alt="{{ $r['name'] }}"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="p-4">
                                                        <p class="font-bold text-gray-800">{{ $r['name'] }}</p>
                                                        <p class="text-xs text-gray-500">ID: {{ $r['id'] }}</p>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                        <div class="mt-2 text-sm text-blue-500">
                                            <a href="{{ route('rooms') }}" target="_blank">Browse All Rooms &rarr;</a>
                                        </div>
                                    @else
                                        <input type="number" id="room_id_manual" min="1" value="{{ $rid ?: '' }}"
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all"
                                            placeholder="Enter Room ID">
                                        <div class="mt-2 text-sm text-blue-500">
                                            <a href="{{ route('rooms') }}" target="_blank">Browse All Rooms &rarr;</a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-between mt-8">
                                <button type="button" id="backTo1"
                                    class="text-gray-500 font-semibold hover:text-gray-800">Back</button>
                                <button type="button" id="toStep3"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-orange-200 shadow-xl transition-all">
                                    Next Step
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Guest Information (Name/Email) -->
                        <div id="step3" class="hidden p-8 animate-fade-in-up">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                                Guest Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all"
                                        placeholder="Juan Dela Cruz">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all"
                                        placeholder="juan@gmail.com">
                                    <p id="gmailHint" class="mt-2 text-xs text-gray-500">We recommend using Gmail for faster
                                        confirmation.</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Special Requests /
                                    Notes</label>
                                <textarea name="notes" rows="3"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:border-blue-500 transition-all"
                                    placeholder="Any special needs?"></textarea>
                            </div>

                            <div class="flex justify-between mt-8">
                                <button type="button" id="backTo2"
                                    class="text-gray-500 font-semibold hover:text-gray-800">Back</button>
                                <button type="button" id="toStep4"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-orange-200 shadow-xl transition-all">
                                    Next Step
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Confirmation & Payment -->
                        <div id="step4" class="hidden p-8 animate-fade-in-up">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <span
                                    class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">4</span>
                                Confirmation & Payment
                            </h2>

                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-6">
                                <h3 class="font-bold text-blue-900 mb-4">Review Details</h3>
                                <dl class="grid grid-cols-2 gap-x-4 gap-y-4 text-sm">
                                    <div>
                                        <dt class="text-blue-400">Guest</dt>
                                        <dd class="font-semibold text-blue-900" id="review_name">—</dd>
                                    </div>
                                    <div>
                                        <dt class="text-blue-400">Email</dt>
                                        <dd class="font-semibold text-blue-900" id="review_email">—</dd>
                                    </div>
                                    <div>
                                        <dt class="text-blue-400">Room</dt>
                                        <dd class="font-semibold text-blue-900" id="review_room">—</dd>
                                    </div>
                                    <div>
                                        <dt class="text-blue-400">Guests</dt>
                                        <dd class="font-semibold text-blue-900" id="review_guests">—</dd>
                                    </div>
                                    <div>
                                        <dt class="text-blue-400">Extra Pax Charge</dt>
                                        <dd class="font-semibold text-blue-900" id="review_extra_charge">—</dd>
                                    </div>
                                    <div>
                                        <dt class="text-blue-400">Dates</dt>
                                        <dd class="font-semibold text-blue-900">
                                            <span id="review_in" class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 font-semibold"></span>
                                            to
                                            <span id="review_out" class="inline-block px-2 py-1 rounded bg-red-100 text-red-700 font-semibold"></span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Upload Payment Proof
                                    (GCash/Bank Transfer)</label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative">
                                    <input type="file" name="payment_proof" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <div class="text-gray-500">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-blue-600">Click to upload</span> or drag and drop
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 mb-8">
                                <input type="checkbox" id="terms"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-5 h-5">
                                <label for="terms" class="text-sm text-gray-600">I agree to the <a href="#"
                                        class="text-blue-600 underline">Terms and Conditions</a></label>
                            </div>

                            <div class="flex justify-between">
                                <button type="button" id="backTo3"
                                    class="text-gray-500 font-semibold hover:text-gray-800">Back</button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-green-200 shadow-xl transition-all w-full md:w-auto">
                                    Complete Booking
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-blue-600 rounded-3xl p-6 text-white shadow-xl sticky top-24">
                    <h3 class="text-xl font-bold mb-6 border-b border-blue-500 pb-4">Booking Summary</h3>

                                    <div class="space-y-4">
                        <div class="bg-blue-700/50 rounded-xl p-4">
                            <p class="text-blue-200 text-xs font-bold uppercase mb-1">Check-in</p>
                            <p id="summary_in" class="text-lg font-semibold">—</p>
                        </div>

                        <div class="bg-red-700/50 rounded-xl p-4">
                            <p class="text-red-200 text-xs font-bold uppercase mb-1">Check-out</p>
                            <p id="summary_out" class="text-lg font-semibold">—</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-700/50 rounded-xl p-4">
                                <p class="text-blue-200 text-xs font-bold uppercase mb-1">Guests</p>
                                <p id="summary_guests" class="text-lg font-semibold">1</p>
                            </div>
                            <div class="bg-blue-700/50 rounded-xl p-4">
                                <p class="text-blue-200 text-xs font-bold uppercase mb-1">Nights</p>
                                <p id="summary_nights" class="text-lg font-semibold">0</p>
                            </div>
                        </div>

                        <div class="bg-white/10 rounded-xl p-4 mt-6">
                            <p class="text-blue-200 text-xs font-bold uppercase mb-1">Total</p>
                            <p class="text-2xl font-bold">Pending</p>
                            <p class="text-xs text-blue-200">Price calculated upon confirmation</p>
                            <p class="text-xs text-blue-200 mt-2" id="summary_extra_charge">Additional: ₱0</p>
                        </div>
                    </div>

                    <button
                        class="w-full mt-6 bg-white text-blue-600 font-bold py-3 rounded-xl hover:bg-blue-50 transition-colors text-sm">
                        Need Help?
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        const steps = [1, 2, 3, 4];
        let currentStep = 1;

        // Elements
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        const checkInHidden = document.getElementById('check_in_hidden');
        const checkOutHidden = document.getElementById('check_out_hidden');
        const displayNights = document.getElementById('display_nights');
        const roomSelect = document.getElementById('room_select');
        const roomManual = document.getElementById('room_id_manual');
        const roomHidden = document.getElementById('room_id_hidden');

        // Summary Elements
        const sIn = document.getElementById('summary_in');
        const sOut = document.getElementById('summary_out');
        const sGuests = document.getElementById('summary_guests');
        const sNights = document.getElementById('summary_nights');

        // Review Elements
        const rName = document.getElementById('review_name');
        const rEmail = document.getElementById('review_email');
        const rRoom = document.getElementById('review_room');
        const rGuests = document.getElementById('review_guests');
        const rIn = document.getElementById('review_in');
        const rOut = document.getElementById('review_out');

        function updateSummary() {
            // Dates & Nights
            const inDate = checkIn.value;
            const outDate = checkOut.value;

            checkInHidden.value = inDate;
            checkOutHidden.value = outDate;

            sIn.textContent = inDate || '—';
            sOut.textContent = outDate || '—';

            if (inDate && outDate) {
                const start = new Date(inDate);
                const end = new Date(outDate);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                if (diffDays > 0) {
                    displayNights.textContent = diffDays;
                    sNights.textContent = diffDays;
                } else {
                    displayNights.textContent = '0';
                    sNights.textContent = '0';
                }
            }

            const a = parseInt(document.getElementById('adults').value || '1', 10);
            const c = parseInt(document.getElementById('children').value || '0', 10);
            const e = parseInt(document.getElementById('extra_pax').value || '0', 10);
            const pax = Math.max(1, a + c + e);
            sGuests.textContent = `PAX ${pax}, Extra Pax ${e}`;
            document.getElementById('guests_hidden').value = pax;
            const extraCharge = Math.max(0, e) * 700;
            const sExtra = document.getElementById('summary_extra_charge');
            if (sExtra) sExtra.textContent = `Additional: ₱${extraCharge.toLocaleString('en-PH')}`;
        }

        // Navigation
        function showStep(step) {
            // Hide all
            steps.forEach(s => {
                document.getElementById('step' + s).classList.add('hidden');

                // Update Progress Visuals
                const pIcon = document.getElementById('p-step' + s);
                if (s < step) {
                    // Completed
                    pIcon.className = "w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg ring-4 ring-white transition-all";
                } else if (s === step) {
                    // Current
                    pIcon.className = "w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg ring-4 ring-blue-100 transition-all scale-110";
                } else {
                    // Future
                    pIcon.className = "w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold ring-4 ring-white transition-all";
                }
            });

            // Show Current
            document.getElementById('step' + step).classList.remove('hidden');

            // Progress Line
            const progress = ((step - 1) / (steps.length - 1)) * 100;
            document.getElementById('progressLine').style.width = progress + '%';

            updateSummary();
            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Listeners
        if (checkIn) checkIn.addEventListener('change', updateSummary);
        if (checkOut) checkOut.addEventListener('change', updateSummary);
        document.getElementById('adults').addEventListener('change', updateSummary);
        document.getElementById('children').addEventListener('change', updateSummary);
        document.getElementById('extra_pax').addEventListener('change', updateSummary);

        // Step 1 -> 2
        document.getElementById('toStep2').addEventListener('click', () => {
            if (!checkIn.value || !checkOut.value) {
                alert('Please select both check-in and check-out dates.');
                return;
            }
            if (new Date(checkOut.value) <= new Date(checkIn.value)) {
                alert('Check-out date must be after check-in date.');
                return;
            }
            showStep(2);
        });

        // Step 2 -> 3
        document.getElementById('toStep3').addEventListener('click', () => {
            const selectedCard = document.querySelector('.room-card[data-selected="true"]');
            const rVal = roomSelect ? roomSelect.value : (roomManual ? roomManual.value : (selectedCard ? selectedCard.getAttribute('data-room-id') : ''));
            if (!rVal) {
                alert('Please select a room.');
                return;
            }
            roomHidden.value = rVal;
            showStep(3);
        });

        // Step 3 -> 4
        document.getElementById('toStep4').addEventListener('click', () => {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            if (!name || !email) {
                alert('Please fill in your details.');
                return;
            }

            // Populate Review
            rName.textContent = name;
            rEmail.textContent = email;
            rRoom.textContent = roomHidden.value;
            const ra = parseInt(document.getElementById('adults').value || '1', 10);
            const rc = parseInt(document.getElementById('children').value || '0', 10);
            const re = parseInt(document.getElementById('extra_pax').value || '0', 10);
            const rpax = Math.max(1, ra + rc + re);
            rGuests.textContent = `PAX ${rpax} (Adult ${ra}, Child ${rc}, Extra Pax ${re})`;
            const rExtra = document.getElementById('review_extra_charge');
            if (rExtra) rExtra.textContent = `₱${(Math.max(0, re) * 700).toLocaleString('en-PH')}`;
            rIn.textContent = checkIn.value;
            rOut.textContent = checkOut.value;

            showStep(4);
        });

        // Back Buttons
        document.getElementById('backTo1').addEventListener('click', () => showStep(1));
        document.getElementById('backTo2').addEventListener('click', () => showStep(2));
        document.getElementById('backTo3').addEventListener('click', () => showStep(3));

        // Init
        const today = new Date().toISOString().split('T')[0];
        if (checkIn) checkIn.min = today;
        if (checkOut) checkOut.min = today;

        // Custom Interactive Calendar Logic (Dual View)
        const grid1 = document.getElementById('calendarGrid1');
        const grid2 = document.getElementById('calendarGrid2');
        const label1 = document.getElementById('monthLabel1');
        const label2 = document.getElementById('monthLabel2');
        let currentCalendarDate = new Date();

        function renderDualCalendar() {
            // Render Left Calendar (Month 0)
            renderSingleGrid(grid1, label1, 0);

            // Render Right Calendar (Month +1)
            renderSingleGrid(grid2, label2, 1);
        }

        function renderSingleGrid(grid, label, monthOffset) {
            if (!grid) return;
            grid.innerHTML = '';

            // Calculate specific month for this grid
            const targetDate = new Date(currentCalendarDate.getFullYear(), currentCalendarDate.getMonth() + monthOffset, 1);
            const year = targetDate.getFullYear();
            const month = targetDate.getMonth();

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay(); // 0 = Sunday

            // Update Label
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            label.textContent = `${monthNames[month]} ${year}`;

            // Empty slots
            for (let i = 0; i < startingDay; i++) {
                const empty = document.createElement('div');
                grid.appendChild(empty);
            }

            // Days
            const todayStr = new Date().toISOString().split('T')[0];
            const checkInVal = checkIn.value;
            const checkOutVal = checkOut.value;

            for (let d = 1; d <= daysInMonth; d++) {
                const dateObj = new Date(year, month, d);
                // ISO String helper
                const dateStr = [
                    dateObj.getFullYear(),
                    String(dateObj.getMonth() + 1).padStart(2, '0'),
                    String(dateObj.getDate()).padStart(2, '0')
                ].join('-');

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = d;
                btn.className = "h-10 w-10 mx-auto rounded-full flex items-center justify-center text-sm font-semibold transition-all ";

                // Past dates
                if (dateStr < todayStr) {
                    btn.classList.add('text-gray-300', 'cursor-not-allowed');
                    btn.disabled = true;
                } else {
                    btn.classList.add('hover:bg-blue-100', 'text-gray-700');

                    // Logic for highlighting
                    if (dateStr === checkInVal) {
                        btn.className = "h-10 w-10 mx-auto rounded-full flex items-center justify-center text-sm font-bold bg-blue-600 text-white shadow-lg shadow-blue-200 transform scale-110 z-10";
                    } else if (dateStr === checkOutVal) {
                        btn.className = "h-10 w-10 mx-auto rounded-full flex items-center justify-center text-sm font-bold bg-red-600 text-white shadow-lg shadow-red-200 transform scale-110 z-10";
                    }

                    // In-between range styling
                    if (checkInVal && checkOutVal && dateStr > checkInVal && dateStr < checkOutVal) {
                        btn.className = "h-10 w-full mx-auto flex items-center justify-center text-sm font-semibold bg-blue-50 text-blue-600 rounded-none";
                    }

                    btn.addEventListener('click', () => {
                        handleDateClick(dateStr);
                    });
                }

                // Grid cell wrapper
                const cell = document.createElement('div');
                cell.className = "flex justify-center items-center py-1 relative";

                // Special visual connector for range (optional visual polish)
                if (checkInVal && checkOutVal && dateStr > checkInVal && dateStr < checkOutVal) {
                    cell.classList.add('bg-blue-50');
                }
                // Fill left side if this is checkout
                if (checkInVal && checkOutVal && dateStr === checkOutVal) {
                    const bg = document.createElement('div');
                    bg.className = "absolute left-0 top-1 bottom-1 w-1/2 bg-red-50 -z-10";
                    cell.appendChild(bg);
                }
                // Fill right side if this is checkin AND checkout exists
                if (checkInVal && checkOutVal && dateStr === checkInVal) {
                    const bg = document.createElement('div');
                    bg.className = "absolute right-0 top-1 bottom-1 w-1/2 bg-blue-50 -z-10";
                    cell.appendChild(bg);
                }

                cell.appendChild(btn);
                grid.appendChild(cell);
            }
        }

        function handleDateClick(dateStr) {
            if (!checkIn.value || (checkIn.value && checkOut.value)) {
                // Reset
                checkIn.value = dateStr;
                checkOut.value = '';
            } else if (checkIn.value && !checkOut.value) {
                if (dateStr < checkIn.value) {
                    checkIn.value = dateStr;
                } else if (dateStr > checkIn.value) {
                    checkOut.value = dateStr;
                }
            }
            updateSummary();
            renderDualCalendar();
        }

        // Navigation Listeners
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
            renderDualCalendar();
        });
        document.getElementById('nextMonth').addEventListener('click', () => {
            currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
            renderDualCalendar();
        });

        // Initial Render
        renderDualCalendar();

        // Hook into existing listeners
        checkIn.addEventListener('change', renderDualCalendar);
        checkOut.addEventListener('change', renderDualCalendar);

        const roomCards = document.querySelectorAll('.room-card');
        roomCards.forEach(el => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.room-card').forEach(x => {
                    x.removeAttribute('data-selected');
                    x.classList.remove('ring-2','ring-blue-500','border-blue-300');
                    x.classList.remove('hover:border-blue-300');
                });
                el.setAttribute('data-selected','true');
                el.classList.add('ring-2','ring-blue-500','border-blue-300');
                roomHidden.value = el.getAttribute('data-room-id');
            });
        });

        updateSummary();
    </script>
@endsection
