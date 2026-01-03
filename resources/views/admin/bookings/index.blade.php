@extends('layouts.admin')

@section('title', 'Booking Management - Admin Panel')
@section('page-title', 'Booking Management')

@section('content')
    <div class="space-y-6">
        <!-- Action Bar -->
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Manage and track all customer booking requests</h3>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ref ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Room ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm font-bold text-blue-600">
                                    {{ $booking->ref }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ strtoupper(substr($booking->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $booking->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $booking->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-medium text-gray-700">
                                        <p><span class="text-blue-500 uppercase font-bold text-[10px]">In:</span> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</p>
                                        <p><span class="text-red-500 uppercase font-bold text-[10px]">Out:</span> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-semibold">
                                    Room #{{ $booking->room_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->status === 'pending')
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 shadow-sm border border-yellow-200">Pending</span>
                                    @elseif($booking->status === 'approved')
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 shadow-sm border border-green-200">Approved</span>
                                    @elseif($booking->status === 'rejected')
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700 shadow-sm border border-red-200">Rejected</span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700 shadow-sm border border-gray-200 text-capitalize">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-sm transition-colors shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-700 mb-1">No bookings found</p>
                                    <p class="text-sm text-gray-500">Customer booking requests will appear here</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
