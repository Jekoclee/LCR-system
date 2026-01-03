@extends('layouts.admin')

@section('title', 'Inquiry Details - Admin Panel')
@section('page-title', 'Inquiry Details')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $inq['name'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $inq['email'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date</p>
                    <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($inq['date'])->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    @if((int)$inq['seen'] === 1)
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700">Seen</span>
                    @else
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Unseen</span>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-2">Subject</p>
                <p class="text-lg font-semibold text-gray-800">{{ $inq['subject'] }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-2">Message</p>
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-gray-800 whitespace-pre-line">
                    {{ $inq['message'] }}
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Send Reply</h3>
                <form method="POST" action="{{ route('admin.inquiries.reply', $inq['id']) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text"
                               name="subject"
                               value="{{ old('subject', 'Re: ' . ($inq['subject'] ?? '')) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message"
                                  rows="6"
                                  required
                                  class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                  placeholder="Type your reply here...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg transition-all">
                        Send Reply
                    </button>
                </form>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.inquiries.index') }}"
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-all">
                    Back
                </a>
                @if((int)$inq['seen'] === 0)
                    <form method="POST" action="{{ route('admin.inquiries.mark-seen', $inq['id']) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold shadow-lg transition-all">
                            Mark as Seen
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('admin.inquiries.destroy', $inq['id']) }}"
                      onsubmit="return confirm('Delete this inquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-lg transition-all">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
