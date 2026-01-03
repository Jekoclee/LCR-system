@extends('layouts.admin')

@section('title', 'Booking Details - Admin Panel')
@section('page-title', 'Booking Details')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.bookings.index') }}"
                class="flex items-center gap-2 text-gray-500 hover:text-gray-700 transition-colors font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Reference:</span>
                <span
                    class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl font-mono font-bold border border-blue-100 shadow-sm">{{ $booking->ref }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-4">
                        <h3 class="text-white font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Customer Information
                        </h3>
                    </div>
                    <div class="p-8 grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Full Name</p>
                            <p class="text-lg font-bold text-gray-800">{{ $booking->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Email Address</p>
                            <p class="text-lg font-bold text-gray-800">{{ $booking->email }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Special Notes</p>
                            <p class="text-gray-600 italic bg-gray-50 p-4 rounded-xl border border-gray-100">
                                {{ $booking->notes ?: 'No special requests provided.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stay Information -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 px-8 py-4">
                        <h3 class="text-white font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Stay Details
                        </h3>
                    </div>
                    <div class="p-8 grid grid-cols-2 gap-8">
                        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                            <p class="text-blue-500 text-xs font-bold uppercase mb-1">Check-in</p>
                            <p class="text-2xl font-bold text-blue-900">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</p>
                            <p class="text-blue-600 text-sm font-medium">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('l') }}</p>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                            <p class="text-red-500 text-xs font-bold uppercase mb-1">Check-out</p>
                            <p class="text-2xl font-bold text-red-900">
                                {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</p>
                            <p class="text-red-600 text-sm font-medium">
                                {{ \Carbon\Carbon::parse($booking->check_out)->format('l') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-gray-100 rounded-2xl">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase">Room ID</p>
                                <p class="text-xl font-bold text-gray-800">Room #{{ $booking->room_id }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-gray-100 rounded-2xl">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase">Total Guests</p>
                                <p class="text-xl font-bold text-gray-800">{{ $booking->guests }} Person(s)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Proof -->
            <div class="space-y-6">
                <!-- Status Control -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Booking Status</h3>

                    <div class="mb-6">
                        @if($booking->status === 'pending')
                            <span
                                class="inline-block px-4 py-2 rounded-xl text-sm font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 w-full text-center shadow-sm">Status:
                                Pending Verification</span>
                        @elseif($booking->status === 'approved')
                            <span
                                class="inline-block px-4 py-2 rounded-xl text-sm font-bold bg-green-100 text-green-700 border border-green-200 w-full text-center shadow-sm">Status:
                                Approved</span>
                        @elseif($booking->status === 'rejected')
                            <span
                                class="inline-block px-4 py-2 rounded-xl text-sm font-bold bg-red-100 text-red-700 border border-red-200 w-full text-center shadow-sm">Status:
                                Rejected</span>
                        @else
                            <span
                                class="inline-block px-4 py-2 rounded-xl text-sm font-bold bg-gray-100 text-gray-700 border border-gray-200 w-full text-center shadow-sm text-capitalize">Status:
                                {{ $booking->status }}</span>
                        @endif
                    </div>

                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Change Status To:</p>
                        <div class="grid grid-cols-1 gap-2">
                            <button type="submit" name="status" value="approved"
                                class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-green-200">
                                Approve Booking
                            </button>
                            <button type="submit" name="status" value="rejected"
                                class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-red-200">
                                Reject Booking
                            </button>
                            <button type="submit" name="status" value="pending"
                                class="w-full px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-bold text-sm transition-all">
                                Mark as Pending
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Payment Proof -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">Payment Proof</h3>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <a href="{{ $booking->proof_url }}" target="_blank"
                            class="group relative block aspect-[3/4] rounded-2xl overflow-hidden shadow-inner border border-gray-200">
                            <img src="{{ $booking->proof_url }}" alt="Payment Proof"
                                class="w-full h-full object-cover transition-transform group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-gray-900 px-4 py-2 rounded-xl font-bold shadow-2xl">View Full
                                    Image</span>
                            </div>
                        </a>
                        <p class="mt-4 text-xs text-center text-gray-400 font-medium italic">Click image to view in full
                            size</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection