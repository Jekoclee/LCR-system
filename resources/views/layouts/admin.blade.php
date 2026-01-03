@php
    $user = auth()->user();
    $isSuperAdmin = $user->role === 'superadmin';

    // Dynamic Theme Configuration
    $theme = $isSuperAdmin ? [
        'sidebar_gradient' => 'from-slate-900 via-amber-950 to-orange-950',
        'logo_gradient' => 'from-amber-200 to-orange-400',
        'role_text' => 'text-amber-400',
        'sub_text' => 'text-amber-200/60',
        'body_gradient' => 'from-orange-50 via-amber-50 to-slate-50',
        'avatar_gradient' => 'from-amber-500 to-orange-600',
        'active_nav' => 'bg-amber-500/15 text-amber-100 shadow-lg border border-amber-400/30 ring-1 ring-amber-300/30',
        'hover_nav' => 'hover:bg-amber-500/10 hover:text-amber-100',
        'logout_hover' => 'hover:bg-red-500/20 text-red-300'
    ] : [
        'sidebar_gradient' => 'from-slate-900 via-blue-900 to-purple-900',
        'logo_gradient' => 'from-white to-blue-200',
        'role_text' => 'text-blue-200',
        'sub_text' => 'text-blue-200/60',
        'body_gradient' => 'from-slate-50 via-blue-50 to-purple-50',
        'avatar_gradient' => 'from-blue-500 to-purple-600',
        'active_nav' => 'bg-white/15 text-white shadow-lg border border-white/20 ring-1 ring-white/30',
        'hover_nav' => 'hover:bg-white/10 text-slate-300 hover:text-white',
        'logout_hover' => 'hover:bg-red-500/20 text-red-200'
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel | LCR Booking')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br {{ $theme['body_gradient'] }} min-h-screen font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside
            class="w-64 bg-gradient-to-br {{ $theme['sidebar_gradient'] }} text-white flex-shrink-0 shadow-2xl relative">

            <!-- Sidebar Background Pattern (Optional) -->
            <div
                class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]">
            </div>

            <div class="p-6 border-b border-white/10 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 {{ $theme['role_text'] }}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r {{ $theme['logo_gradient'] }} bg-clip-text text-transparent">
                            {{ $isSuperAdmin ? 'Super Admin Panel' : 'Admin Panel' }}
                        </h1>
                        <p class="text-[10px] uppercase tracking-wider font-bold {{ $theme['role_text'] }}">
                            {{ $isSuperAdmin ? 'Super Administrator' : 'Administrator' }}
                        </p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2 relative z-10">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.bookings.*') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Bookings</span>
                </a>

                <a href="{{ route('admin.rooms.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.rooms.*') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 7a2 2 0 012-2h2l2-2h4l2 2h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                    </svg>
                    <span class="font-medium">Rooms</span>
                </a>

                <a href="{{ route('admin.room-reviews.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.room-reviews.*') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 1.343-3 3v7h6v-7c0-1.657-1.343-3-3-3zm0-4a4 4 0 014 4h-8a4 4 0 014-4z" />
                    </svg>
                    <span class="font-medium">Room Ratings</span>
                </a>

                <a href="{{ route('admin.inquiries.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.inquiries.*') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 8h2a2 2 0 012 2v7a2 2 0 01-2 2H7l-4 4V10a2 2 0 012-2h2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 12h.01M16 12h.01M8 12h.01" />
                    </svg>
                    <span class="font-medium">User Inquiries</span>
                </a>

                @if($isSuperAdmin)
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium">Users Management</span>
                    </a>
                    <a href="{{ route('admin.admins.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.admins.*') ? 'backdrop-blur-sm ' . $theme['active_nav'] : $theme['hover_nav'] }} transition-all group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium">Admin Management</span>
                    </a>
                @endif

                <div class="pt-4 mt-4 border-t border-white/10">
                    <p class="px-4 text-xs font-semibold {{ $theme['sub_text'] }} uppercase mb-2">My Account</p>

                    <a href="{{ url('/') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $theme['hover_nav'] }} transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="font-medium">Back to Website</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl {{ $theme['logout_hover'] }} transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm z-20 sticky top-0">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>

                    <div class="flex items-center gap-4">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            @if(!$isSuperAdmin)
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            @endif
                            @if($isSuperAdmin)
                                <span class="mt-1 inline-block text-[10px] font-bold uppercase px-2 py-1 rounded-md bg-amber-100 text-amber-700 tracking-widest">SUPERADMIN</span>
                            @else
                                <span class="mt-1 inline-block text-[10px] font-bold uppercase px-2 py-1 rounded-md bg-blue-100 text-blue-700 tracking-widest">ADMIN</span>
                            @endif
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-gradient-to-br {{ $theme['avatar_gradient'] }} flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 animate-fade-in">
                        <div class="bg-green-100 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 animate-fade-in">
                        <div class="bg-red-100 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-orange-50 border border-orange-200 text-orange-800 px-6 py-4 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="font-bold">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 ml-3 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
