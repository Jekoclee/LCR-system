<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-900 text-white antialiased font-sans">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/10 p-6 rounded-2xl">
            <h1 class="text-2xl font-bold mb-4">Sign In</h1>
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-300 bg-red-600/20 border border-red-500/30 px-3 py-2 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500" placeholder="you@example.com" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password" name="password" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500" placeholder="••••••••" required>
                </div>
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-300">
                        <input type="checkbox" name="remember" class="rounded bg-black/40 border-white/20">
                        Remember me
                    </label>
                    <a href="{{ route('register') }}" class="text-blue-300 hover:text-blue-200 text-sm">Create account</a>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
