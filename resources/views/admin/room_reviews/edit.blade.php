@extends('layouts.admin')

@section('title', 'Edit Review - Admin Panel')
@section('page-title', 'Edit Review')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Room</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $roomsMap[$roomReview->room_id] ?? 'Room #'.$roomReview->room_id }}
                        <span class="text-xs text-gray-500">(#{{ $roomReview->room_id }})</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">User</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $roomReview->user->name ?? 'Unknown' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.room-reviews.update', $roomReview) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <select name="rating"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected(old('rating', $roomReview->rating) == $i)>{{ $i }} stars</option>
                        @endfor
                    </select>
                    @error('rating')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Review</label>
                    <textarea name="review" rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">{{ old('review', $roomReview->review) }}</textarea>
                    @error('review')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Reply</label>
                    <textarea name="admin_reply" rows="5"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                              placeholder="Type your reply to the customer">{{ old('admin_reply', $roomReview->admin_reply) }}</textarea>
                    @error('admin_reply')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.room-reviews.index') }}"
                       class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg transition-all">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
