@extends('layouts.app')

@section('title', 'Your Profile | LCR Booking')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 pb-12">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/10 p-8 rounded-2xl shadow-2xl">
            <h1 class="text-3xl font-bold mb-6 text-white tracking-tight">Your Profile</h1>

            @if (session('status'))
                <div class="mb-6 text-sm text-emerald-300 bg-emerald-600/20 border border-emerald-500/30 px-4 py-3 rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 text-sm text-red-300 bg-red-600/20 border border-red-500/30 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-500/30 shadow-2xl relative">
                            @if($user->profile_picture)
                                <img id="avatar-preview" src="{{ asset('uploads/profile/' . $user->profile_picture) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div id="avatar-placeholder"
                                    class="w-full h-full bg-blue-900/50 flex items-center justify-center text-4xl font-bold text-blue-300">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <img id="avatar-preview" src="#" class="w-full h-full object-cover hidden">
                            @endif
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                                onclick="document.getElementById('profile_picture').click()">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <input type="file" name="profile_picture" id="profile_picture" class="hidden"
                            onchange="previewAvatar(this)">
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Click to change avatar</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Email Address</label>
                    <input type="email" value="{{ $user->email }}"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-gray-400 cursor-not-allowed"
                        disabled>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                        required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Birth Date</label>
                        <input type="date" name="dob" value="{{ old('dob', $user->dob) }}"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                            placeholder="09xxxxxxxxx">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Address</label>
                    <textarea name="address" rows="3"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                        placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="pt-4 border-t border-white/5 space-y-5">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Change Password</p>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">New Password</label>
                        <input type="password" name="password"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                            placeholder="Leave blank to keep current">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] mt-6">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('avatar-preview');
                    const placeholder = document.getElementById('avatar-placeholder');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection