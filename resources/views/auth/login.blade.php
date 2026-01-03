<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($isAdminView ?? false) ? 'Admin Sign In' : 'Sign In' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-900 text-white antialiased font-sans">
    <div class="relative min-h-screen">
        <div class="absolute inset-0 -z-10">
            @if(file_exists(public_path('images/homepage/hero-user.jpg')))
                <img src="{{ asset('images/homepage/hero-user.jpg') }}" alt="Background" class="w-full h-full object-cover">
            @elseif(file_exists(public_path('images/homepage/lcr.jpeg')))
                <img src="{{ asset('images/homepage/lcr.jpeg') }}" alt="Background" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('lcr.jpeg') }}" alt="Background" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-br from-[#0a1128]/80 via-[#0a1128]/60 to-black/60"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-16 md:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="reveal-left" style="--delay: 120ms">
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-3 py-1.5 rounded-lg mb-6">
                        <span class="text-xs font-bold tracking-[0.3em] text-gray-300">
                            {{ ($isAdminView ?? false) ? 'ADMIN ACCESS' : 'ACCOUNT ACCESS' }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-6">
                        {{ ($isAdminView ?? false) ? 'Admin Sign In' : 'Sign In' }}
                    </h1>
                    <p class="text-blue-100/80 text-lg max-w-xl">
                        {{ ($isAdminView ?? false) ? 'Only admins and superadmins can sign in here.' : 'Sign in to your customer account.' }}
                    </p>
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('rooms') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-md shadow-lg shadow-blue-900/40 text-sm tracking-widest uppercase">Explore
                            Rooms</a>
                        <a href="{{ route('dining.sabina') }}"
                            class="bg-transparent text-white border border-white/20 font-bold px-6 py-3 rounded-md hover:bg-white/10 text-sm tracking-widest uppercase">Dining</a>
                    </div>
                </div>

                <div class="reveal-right" style="--delay: 240ms">
                    <div
                        class="w-full max-w-md ml-auto bg-white/10 backdrop-blur-xl border border-white/10 p-8 rounded-2xl shadow-2xl">
                        <h2 class="text-2xl font-bold mb-6">
                            {{ ($isAdminView ?? false) ? 'Admin Sign In' : 'Sign In' }}
                        </h2>
                        @if ($errors->any())
                            <div
                                class="mb-4 text-sm text-red-300 bg-red-600/20 border border-red-500/30 px-3 py-2 rounded-lg">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Name or
                                    Email</label>
                                <input type="text" name="login" value="{{ old('login') }}"
                                    class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                    placeholder="e.g. Tine" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Password</label>
                                <input type="password" name="password"
                                    class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500"
                                    placeholder="••••••••" required>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-300">
                                    <input type="checkbox" name="remember" class="rounded bg-black/40 border-white/20">
                                    Remember me
                                </label>
                                <a href="{{ route('register') }}"
                                    class="text-blue-300 hover:text-blue-200 text-sm">Create account</a>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-900/40">Sign
                                In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
