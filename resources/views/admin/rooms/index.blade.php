@extends('layouts.admin')

@section('title', 'Rooms Management - Admin Panel')
@section('page-title', 'Rooms Management')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">I-manage ang available units</h3>
                <p class="text-sm text-gray-500">Data source: LCR WEBSITE admin</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <div class="p-6 border-b border-gray-100 flex justify-end">
                    <button id="openAddRoomModal"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Room
                    </button>
                </div>
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Room</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Available Units</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ strtoupper(substr($room['name'] ?? 'R', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $room['name'] ?? ('Room ' . $room['id']) }}</p>
                                        <span class="text-xs text-gray-500">ID: {{ $room['id'] }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!is_null($room['units']))
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">{{ $room['units'] }}</span>
                                @else
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gray-50 text-gray-600 border border-gray-100">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="inline-flex items-center gap-2">
                                    <details class="relative">
                                        <summary class="list-none">
                                            <button type="button" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-bold shadow-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m2 0h2m-6 4h6m-10 8h10M7 9h2m-2 4h2m-2 4h2" />
                                                </svg>
                                                Edit
                                            </button>
                                        </summary>
                                        <div class="absolute right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-xl p-4 w-80 z-10">
                                            <form method="POST" action="{{ route('admin.rooms.update-full', ['id' => $room['id']]) }}" class="space-y-3">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Room Name</label>
                                                    <input type="text" name="name" value="{{ $room['name'] }}" required
                                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-gray-700 focus:outline-none focus:border-blue-500 transition-all">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Available Units</label>
                                                    <input type="number" name="units" min="0" step="1" value="{{ !is_null($room['units']) ? $room['units'] : 0 }}" required
                                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-gray-700 focus:outline-none focus:border-purple-500 transition-all">
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-bold shadow-lg transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </details>
                                    <form method="POST" action="{{ route('admin.rooms.destroy', ['id' => $room['id']]) }}" onsubmit="return confirm('Delete this room?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-bold shadow-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Walang data na nakuha</p>
                                <p class="text-sm text-gray-500">I-check ang LCR WEBSITE admin o rates page</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div id="addRoomModal" class="hidden fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative max-w-lg mx-auto mt-24 bg-white rounded-2xl shadow-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Room</h3>
                    <button id="closeAddRoomModal" class="inline-flex items-center justify-center h-9 w-9 rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Room Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:border-blue-500 transition-all"
                               placeholder="Enter room name">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Price</label>
                            <input type="number" name="price" min="0" step="1" value="{{ old('price') }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:border-purple-500 transition-all"
                                   placeholder="0">
                            @error('price')
                                <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Available Units</label>
                            <input type="number" name="units" min="0" step="1" value="{{ old('units') }}" required
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:border-purple-500 transition-all"
                                   placeholder="0">
                            @error('units')
                                <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:border-blue-500 transition-all"
                                  placeholder="Optional description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" id="cancelAddRoomModal"
                                class="px-5 py-2.5 rounded-xl font-bold border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            (function() {
                var openBtn = document.getElementById('openAddRoomModal');
                var modal = document.getElementById('addRoomModal');
                var closeBtn = document.getElementById('closeAddRoomModal');
                var cancelBtn = document.getElementById('cancelAddRoomModal');
                function open() { modal.classList.remove('hidden'); }
                function close() { modal.classList.add('hidden'); }
                if (openBtn) openBtn.addEventListener('click', open);
                if (closeBtn) closeBtn.addEventListener('click', close);
                if (cancelBtn) cancelBtn.addEventListener('click', close);
                var hasErrors = {{ $errors->any() ? 'true' : 'false' }};
                var hasErrorFlash = {{ session('error') ? 'true' : 'false' }};
                if (hasErrors || hasErrorFlash) { open(); }
                var successMsg = {!! json_encode(session('success')) !!};
                if (successMsg) {
                    var toast = document.createElement('div');
                    toast.className = 'fixed bottom-6 right-6 bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2';
                    var icon = document.createElement('span');
                    icon.innerHTML = '<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /></svg>';
                    var text = document.createElement('span');
                    text.textContent = successMsg;
                    var closeX = document.createElement('button');
                    closeX.className = 'ml-2 hover:bg-green-700/50 rounded-full p-1';
                    closeX.innerHTML = '<svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\" /></svg>';
                    closeX.addEventListener('click', function(){ document.body.removeChild(toast); });
                    toast.appendChild(icon);
                    toast.appendChild(text);
                    toast.appendChild(closeX);
                    document.body.appendChild(toast);
                    setTimeout(function(){ if (document.body.contains(toast)) document.body.removeChild(toast); }, 3000);
                }
            })();
        </script>
    </div>
@endsection
