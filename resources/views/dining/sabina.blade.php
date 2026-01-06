@extends('layouts.app')

@section('title', 'Sabina Restaurant | Dining | LCR Booking')

@push('styles')
    <style>
        /* 3D FlipBook Stlying */
        .book-wrapper {
            perspective: 2000px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 620px;
            width: 100%;
        }

        .book {
            display: flex;
            transform-style: preserve-3d;
            width: 840px;
            height: 560px;
            position: relative;
        }

        .page {
            width: 420px;
            /* Half of book width */
            height: 100%;
            position: absolute;
            top: 0;
            right: auto;
            left: calc(50% - 210px);
            transform-origin: left center;
            transform-style: preserve-3d;
            transition: transform 1s cubic-bezier(0.15, 0.52, 0.59, 1), opacity .4s ease;
            cursor: pointer;
            background: white;
            box-shadow: inset 5px 0 10px rgba(0, 0, 0, 0.05);
            opacity: 0;
            pointer-events: none;
        }

        .page.show {
            opacity: 1;
            pointer-events: auto;
        }

        .page-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            overflow: hidden;
            border-right: 1px solid #ddd;
        }

        .page-front {
            /* Default front facing */
        }

        .page-back {
            transform: rotateY(180deg);
            border-right: none;
            border-left: 1px solid #ddd;
            /* box-shadow: inset -5px 0 10px rgba(0,0,0,0.05); */
        }

        /* Z-index layering for pages */
        #p1 {
            z-index: 5;
        }

        #p2 {
            z-index: 4;
        }

        #p3 {
            z-index: 3;
        }

        #p4 {
            z-index: 2;
        }

        /* Flip states */
        .flipped {
            transform: rotateY(-180deg);
        }

        /* Viewer UI */
        .nav-btn {
            background: rgba(10, 17, 40, 0.55);
            border: 1px solid rgba(59, 130, 246, 0.25);
            color: #e5e7eb;
            width: 42px;
            height: 42px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(6px);
            transition: all .2s ease;
        }
        .nav-btn:hover {
            background: rgba(37, 99, 235, 0.45);
            transform: scale(1.06);
        }
        .thumb {
            width: 60px;
            height: 90px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.15);
            overflow: hidden;
            cursor: pointer;
            opacity: .6;
            transition: all .2s ease;
            background: #0f172a;
        }
        .thumb:hover { opacity: .85; transform: translateY(-1px); }
        .thumb.active {
            opacity: 1;
            box-shadow: 0 0 0 2px rgba(59,130,246,.6), 0 8px 24px rgba(2,6,23,.35);
            border-color: rgba(59,130,246,.5);
        }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
@endpush

@section('content')
    <div class="pt-20 bg-[#0a1128] min-h-screen">
        <!-- Hero Section -->
        <div class="relative h-[60vh] min-h-[400px] overflow-hidden">
            <div class="absolute inset-0">
                @if(file_exists(public_path('images/dining/hero.jpg')))
                    <img src="{{ asset('images/dining/hero.jpg') }}" alt="Sabina Restaurant"
                        class="w-full h-full object-cover opacity-60">
                @elseif(file_exists(public_path('images/dining/sabina.jpg')))
                    <img src="{{ asset('images/dining/sabina.jpg') }}" alt="Sabina Restaurant"
                        class="w-full h-full object-cover opacity-60">
                @else
                    <img src="{{ asset('lcr.jpeg') }}" alt="Sabina Restaurant" class="w-full h-full object-cover opacity-50">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#0a1128] via-[#0a1128]/40 to-transparent"></div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12 max-w-7xl mx-auto text-center md:text-left">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-blue-600/30 border border-blue-500/50 text-blue-300 text-sm font-bold tracking-widest uppercase mb-4 backdrop-blur-md">
                    Fine Dining
                </span>
                <h1 class="text-5xl md:text-7xl font-bold tracking-tighter text-white mb-6">Sabina Restaurant</h1>
                <p class="text-xl text-gray-200 max-w-2xl leading-relaxed">Discover a world of flavors where local
                    ingredients meet international culinary excellence.</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 gap-16">
                <div class="space-y-12">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-white mb-6">About the Experience</h2>
                        <p class="text-gray-400 leading-relaxed text-lg">
                            Sabina Restaurant offers an elegant atmosphere perfect for any occasion. From intimate dinners
                            to celebratory gatherings, our chefs prepare each dish with passion and precision. Our menu
                            features a curated selection of contemporary Asian and Western cuisine.
                        </p>
                    </div>

                    <!-- Hours -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div
                            class="bg-white/5 border border-white/10 p-8 rounded-2xl group hover:border-blue-500/30 transition-all">
                            <div
                                class="w-12 h-12 rounded-full bg-blue-900/40 flex items-center justify-center text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-xl text-white mb-2">Breakfast Buffet</h4>
                            <p class="text-gray-400 text-sm">6:00 AM - 10:30 AM Daily</p>
                        </div>
                        <div
                            class="bg-white/5 border border-white/10 p-8 rounded-2xl group hover:border-blue-500/30 transition-all">
                            <div
                                class="w-12 h-12 rounded-full bg-blue-900/40 flex items-center justify-center text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-xl text-white mb-2">Dinner Service</h4>
                            <p class="text-gray-400 text-sm">6:00 PM - 11:00 PM Daily</p>
                        </div>
                    </div>

                    <!-- Digital Menu Feature -->
                    <div
                        class="bg-gradient-to-r from-blue-900/20 to-blue-800/10 border border-blue-500/20 rounded-2xl p-8 relative overflow-hidden group">
                        <div
                            class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all">
                        </div>
                        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                            <div class="flex-1 text-center md:text-left">
                                <h3 class="text-2xl font-bold text-white mb-2">View Our Interactive Menu</h3>
                                <p class="text-gray-400 mb-6">Browse our culinary offerings with our digital flipbook menu.
                                </p>
                                <button type="button" onclick="openMenuModal()"
                                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition-all shadow-lg shadow-blue-900/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Open Digital Menu
                                </button>
                            </div>
                            <div
                                class="w-32 h-32 md:w-40 md:h-40 bg-black/40 rounded-xl rotate-3 border border-white/10 flex items-center justify-center p-2 shadow-xl group-hover:rotate-6 transition-transform">
                                <!-- Preview Image Placeholder -->
                                <span class="text-xs text-gray-500 uppercase font-bold text-center">Menu Preview</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-white mb-2">Sabina Menu</h3>
                    <div class="w-24 h-1 bg-blue-600 rounded-full mb-6"></div>
                    @php
                        $inlineDirs = [
                            public_path('images/dining'),
                            public_path('images/sabina'),
                        ];
                        $inlineMenuFiles = [];
                        foreach ($inlineDirs as $dir) {
                            if (is_dir($dir)) {
                                $files = @scandir($dir) ?: [];
                                foreach ($files as $fn) {
                                    if (preg_match('/^menu\\d+\\.(jpg|jpeg|png|webp)$/i', $fn)) {
                                        $inlineMenuFiles[] = [
                                            'disk' => $dir . DIRECTORY_SEPARATOR . $fn,
                                            'url' => asset('images/' . basename($dir) . '/' . $fn),
                                        ];
                                    }
                                }
                            }
                        }
                        usort($inlineMenuFiles, function ($a, $b) {
                            $na = (int) preg_replace('/\\D+/', '', basename($a['disk']));
                            $nb = (int) preg_replace('/\\D+/', '', basename($b['disk']));
                            return $na <=> $nb;
                        });
                        if (empty($inlineMenuFiles)) {
                            foreach (range(1, 9) as $i) {
                                $path = public_path('images/dining/menu' . $i . '.jpg');
                                if (file_exists($path)) {
                                    $inlineMenuFiles[] = [
                                        'disk' => $path,
                                        'url' => asset('images/dining/menu' . $i . '.jpg'),
                                    ];
                                }
                            }
                        }
                        $inlineSpreads = [];
                        for ($i = 0; $i < count($inlineMenuFiles); $i += 2) {
                            $front = $inlineMenuFiles[$i] ?? null;
                            $back = $inlineMenuFiles[$i + 1] ?? null;
                            if ($front) {
                                $inlineSpreads[] = [
                                    'front' => $front,
                                    'back' => $back,
                                ];
                            }
                        }
                    @endphp
                    @if(count($inlineSpreads))
                        <div class="relative max-w-5xl mx-auto bg-blue-950/30 border border-blue-900/40 rounded-2xl p-6 shadow-2xl">
                            <button onclick="prevPageInline()" class="nav-btn absolute left-3 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button onclick="nextPageInline()" class="nav-btn absolute right-3 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <div class="book-wrapper">
                                <div id="inline-book" class="book">
                                    @foreach($inlineSpreads as $idx => $spread)
                                        @php
                                            $id = 'ip' . ($idx + 1);
                                            $z = (count($inlineSpreads) + 1) - $idx;
                                            $frontUrl = $spread['front']['url'] . '?v=' . @filemtime($spread['front']['disk']);
                                            $backUrl = $spread['back'] ? ($spread['back']['url'] . '?v=' . @filemtime($spread['back']['disk'])) : null;
                                        @endphp
                                        <div class="page" id="{{ $id }}" style="z-index: {{ $z }};">
                                            <div class="page-face page-front">
                                                <img src="{{ $frontUrl }}" class="w-full h-full object-contain bg-[#0b122f]" alt="Menu {{ $idx*2+1 }}">
                                            </div>
                                            <div class="page-face page-back">
                                                @if($backUrl)
                                                    <img src="{{ $backUrl }}" class="w-full h-full object-contain bg-[#0b122f]" alt="Menu {{ $idx*2+2 }}">
                                                @else
                                                    <div class="w-full h-full bg-[#0b122f] flex items-center justify-center text-gray-400 text-sm">No Back Page</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4 text-blue-200/70 text-sm font-semibold tracking-wide text-center">
                                Page <span id="inline-page-indicator">1</span> of {{ max(1, count($inlineSpreads) + 1) }}
                            </div>
                        </div>
                        <div class="mt-6 no-scrollbar overflow-x-auto">
                            <div class="flex items-center justify-center gap-3 min-w-full">
                                @foreach($inlineSpreads as $tidx => $spread)
                                    @php
                                        $turl = $spread['front']['url'] . '?v=' . @filemtime($spread['front']['disk']);
                                    @endphp
                                    <div class="thumb" data-thumb="{{ $tidx+1 }}" onclick="gotoPageInline({{ $tidx+1 }})">
                                        <img src="{{ $turl }}" class="w-full h-full object-cover" alt="Thumb {{ $tidx+1 }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-gray-400">No menu images found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Digital Menu Modal -->
    <div id="flip-menu-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-xl" onclick="closeMenuModal()"></div>

        <div class="relative w-full max-w-7xl h-screen flex flex-col items-center justify-center pointer-events-none">
            <!-- Close Button -->
            <button
                class="absolute top-6 right-6 text-white/50 hover:text-white z-[110] transition-colors pointer-events-auto"
                onclick="closeMenuModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Navigation Buttons -->
            <div
                class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4 md:px-12 z-[105] w-full pointer-events-none">
                <button onclick="prevPage()"
                    class="bg-black/50 hover:bg-blue-600/80 text-white p-4 rounded-full backdrop-blur-md transition-all transform hover:scale-110 pointer-events-auto border border-white/10 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 group-hover:-translate-x-1 transition-transform"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button onclick="nextPage()"
                    class="bg-black/50 hover:bg-blue-600/80 text-white p-4 rounded-full backdrop-blur-md transition-all transform hover:scale-110 pointer-events-auto border border-white/10 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 group-hover:translate-x-1 transition-transform"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            @php
                $dirs = [
                    public_path('images/dining'),
                    public_path('images/sabina'),
                ];
                $menuFiles = [];
                foreach ($dirs as $dir) {
                    if (is_dir($dir)) {
                        $files = @scandir($dir) ?: [];
                        foreach ($files as $fn) {
                            if (preg_match('/^menu\\d+\\.(jpg|jpeg|png|webp)$/i', $fn)) {
                                $menuFiles[] = [
                                    'disk' => $dir . DIRECTORY_SEPARATOR . $fn,
                                    'url' => asset('images/' . basename($dir) . '/' . $fn),
                                ];
                            }
                        }
                    }
                }
                usort($menuFiles, function ($a, $b) {
                    $na = (int) preg_replace('/\\D+/', '', basename($a['disk']));
                    $nb = (int) preg_replace('/\\D+/', '', basename($b['disk']));
                    return $na <=> $nb;
                });
                if (empty($menuFiles)) {
                    // Fallback static list
                    foreach (range(1, 9) as $i) {
                        $path = public_path('images/dining/menu' . $i . '.jpg');
                        if (file_exists($path)) {
                            $menuFiles[] = [
                                'disk' => $path,
                                'url' => asset('images/dining/menu' . $i . '.jpg'),
                            ];
                        }
                    }
                }
                // Pair images into spreads (front/back)
                $spreads = [];
                for ($i = 0; $i < count($menuFiles); $i += 2) {
                    $front = $menuFiles[$i] ?? null;
                    $back = $menuFiles[$i + 1] ?? null;
                    if ($front) {
                        $spreads[] = [
                            'front' => $front,
                            'back' => $back,
                        ];
                    }
                }
            @endphp
            <div
                class="book-wrapper pointer-events-auto scale-[0.5] sm:scale-[0.6] md:scale-[0.7] lg:scale-[0.85] xl:scale-100 transition-transform">
                <div id="book" class="book">
                    @foreach($spreads as $idx => $spread)
                        @php
                            $id = 'p' . ($idx + 1);
                            $z = (count($spreads) + 1) - $idx;
                            $frontUrl = $spread['front']['url'] . '?v=' . @filemtime($spread['front']['disk']);
                            $backUrl = $spread['back'] ? ($spread['back']['url'] . '?v=' . @filemtime($spread['back']['disk'])) : null;
                        @endphp
                        <div class="page" id="{{ $id }}" style="z-index: {{ $z }};">
                            <div class="page-face page-front">
                                <img src="{{ $frontUrl }}" class="w-full h-full object-contain bg-[#1a1a1a]" alt="Menu {{ $idx*2+1 }}">
                            </div>
                            <div class="page-face page-back">
                                @if($backUrl)
                                    <img src="{{ $backUrl }}" class="w-full h-full object-contain bg-[#1a1a1a]" alt="Menu {{ $idx*2+2 }}">
                                @else
                                    <div class="w-full h-full bg-[#1a1a1a] flex items-center justify-center text-gray-400 text-sm">No Back Page</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 text-white/50 text-sm font-medium tracking-wide">
                Page <span id="page-indicator">1</span> of {{ max(1, count($spreads) + 1) }}
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('flip-menu-modal');
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        let currentPage = 0; // 0 = Closed/Start, 1 = p1 flipped, 2 = p2 flipped...
        const totalPages = {{ count($spreads) }};

        function playFlipSound() {
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(400, audioCtx.currentTime);
            oscillator.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.15);

            gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.15);

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.start();
            oscillator.stop(audioCtx.currentTime + 0.2);
        }

        function openMenuModal() {
            modal.classList.remove('hidden');
            resetBook();
        }

        function closeMenuModal() {
            modal.classList.add('hidden');
        }

        function resetBook() {
            currentPage = 0;
            updateZIndexes();
            for (let i = 1; i <= totalPages; i++) {
                document.getElementById('p' + i).classList.remove('flipped');
            }
            updateIndicator();
        }

        function updateIndicator() {
            // Indicator logic: 
            // State 0: Seeing Page 1 Front (Cover) -> Page 1
            // State 1: Seeing Page 1 Back & Page 2 Front -> Page 2-3
            // ...
            // Simplified: Just show "Spread X"
            const indicator = document.getElementById('page-indicator');
            indicator.innerText = (currentPage + 1);
        }

        function nextPage() {
            if (currentPage < totalPages) {
                playFlipSound();
                currentPage++;
                const page = document.getElementById('p' + currentPage);
                page.style.zIndex = 10 + currentPage; // Bring to top during flip
                page.classList.add('flipped');
                updateIndicator();

                // After flip, adjust Z-index for stacking on left
                setTimeout(() => {
                    updateZIndexes();
                }, 500);
            }
        }

        function prevPage() {
            if (currentPage > 0) {
                playFlipSound();
                const page = document.getElementById('p' + currentPage);
                page.classList.remove('flipped');
                currentPage--;
                updateIndicator();

                // Immediately adjust z-index to help it slide back under if needed, 
                // but usually for unflip we want it high then low.
                // The CSS transition handles the visual flip. 
                // We need to ensure it lands correct stack.
                setTimeout(() => {
                    updateZIndexes();
                }, 500);
            }
        }

        function updateZIndexes() {
            // Right Stack (Unflipped): Lower ID = Higher Z
            // Left Stack (Flipped): Higher ID = Higher Z

            for (let i = 1; i <= totalPages; i++) {
                const p = document.getElementById('p' + i);
                if (i <= currentPage) {
                    // Flipped (Left Side)
                    // Stack: p1 bottom, p4 top.
                    p.style.zIndex = i;
                } else {
                    // Unflipped (Right Side)
                    // Stack: p1 top, p4 bottom.
                    // If p1 is flipped, p2 is top of right stack.
                    p.style.zIndex = (totalPages + 5) - i;
                }
                // Visibility: single-page view (show ONLY the right page)
                const target = Math.min(totalPages, currentPage + 1);
                const shouldShow = (i === target);
                if (shouldShow) {
                    p.classList.add('show');
                } else {
                    p.classList.remove('show');
                }
            }
        }
        // Click to flip/unflip
        document.querySelectorAll('#book .page').forEach((pg, idx) => {
            pg.addEventListener('click', () => {
                const target = idx + 1;
                if (target > currentPage) {
                    nextPage();
                } else {
                    prevPage();
                }
            });
        });

        let inlineCurrentPage = 0;
        const inlineTotalPages = {{ count($inlineSpreads ?? []) }};
        function updateInlineIndicator() {
            const indicator = document.getElementById('inline-page-indicator');
            if (indicator) indicator.innerText = (inlineCurrentPage + 1);
        }
        function nextPageInline() {
            if (inlineCurrentPage < inlineTotalPages) {
                playFlipSound();
                inlineCurrentPage++;
                const page = document.getElementById('ip' + inlineCurrentPage);
                if (page) {
                    page.style.zIndex = 10 + inlineCurrentPage;
                    page.classList.add('flipped');
                }
                updateInlineIndicator();
                setTimeout(() => {
                    for (let i = 1; i <= inlineTotalPages; i++) {
                        const p = document.getElementById('ip' + i);
                        if (!p) continue;
                        p.style.zIndex = i <= inlineCurrentPage ? i : (inlineTotalPages + 5) - i;
                        const target = Math.min(inlineTotalPages, inlineCurrentPage + 1);
                        const show = (i === target);
                        if (show) p.classList.add('show'); else p.classList.remove('show');
                    }
                    updateThumbsInline();
                }, 500);
            }
        }
        function prevPageInline() {
            if (inlineCurrentPage > 0) {
                playFlipSound();
                const page = document.getElementById('ip' + inlineCurrentPage);
                if (page) page.classList.remove('flipped');
                inlineCurrentPage--;
                updateInlineIndicator();
                setTimeout(() => {
                    for (let i = 1; i <= inlineTotalPages; i++) {
                        const p = document.getElementById('ip' + i);
                        if (!p) continue;
                        p.style.zIndex = i <= inlineCurrentPage ? i : (inlineTotalPages + 5) - i;
                        const target = Math.min(inlineTotalPages, inlineCurrentPage + 1);
                        const show = (i === target);
                        if (show) p.classList.add('show'); else p.classList.remove('show');
                    }
                    updateThumbsInline();
                }, 500);
            }
        }
        function gotoPageInline(n) {
            // n is 1-based spread index
            // Reset all pages and set currentPage to n-1 then flip forward
            for (let i = 1; i <= inlineTotalPages; i++) {
                const p = document.getElementById('ip' + i);
                if (p) p.classList.remove('flipped');
            }
            inlineCurrentPage = 0;
            for (let i = 1; i < n; i++) {
                const page = document.getElementById('ip' + i);
                if (page) page.classList.add('flipped');
                inlineCurrentPage = i;
            }
            updateInlineIndicator();
            for (let i = 1; i <= inlineTotalPages; i++) {
                const p = document.getElementById('ip' + i);
                if (!p) continue;
                p.style.zIndex = i <= inlineCurrentPage ? i : (inlineTotalPages + 5) - i;
                const target = Math.min(inlineTotalPages, inlineCurrentPage + 1);
                const show = (i === target);
                if (show) p.classList.add('show'); else p.classList.remove('show');
            }
            updateThumbsInline();
        }
        function updateThumbsInline() {
            const active = inlineCurrentPage + 1; // right page we show
            document.querySelectorAll('.thumb').forEach((el) => {
                const idx = Number(el.getAttribute('data-thumb'));
                if (idx === active) el.classList.add('active');
                else el.classList.remove('active');
            });
        }
        document.querySelectorAll('#inline-book .page').forEach((pg, idx) => {
            pg.addEventListener('click', () => {
                const target = idx + 1;
                if (target > inlineCurrentPage) {
                    nextPageInline();
                } else {
                    prevPageInline();
                }
            });
        });
        updateZIndexes();
        for (let i = 1; i <= inlineTotalPages; i++) {
            const p = document.getElementById('ip' + i);
            if (!p) continue;
            const target = Math.min(inlineTotalPages, inlineCurrentPage + 1);
            const show = (i === target);
            if (show) p.classList.add('show'); else p.classList.remove('show');
        }
        updateThumbsInline();

        (function(){
            function handleArrow(e) {
                if (e.repeat) return;
                var k = e.key || e.code;
                var keyCode = e.keyCode || e.which;
                var isRight = (k === 'ArrowRight' || k === 'Right' || k === 'KeyD' || keyCode === 39);
                var isLeft = (k === 'ArrowLeft' || k === 'Left' || k === 'KeyA' || keyCode === 37);
                if (isRight) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (modal && !modal.classList.contains('hidden')) nextPage(); else nextPageInline();
                } else if (isLeft) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (modal && !modal.classList.contains('hidden')) prevPage(); else prevPageInline();
                }
            }
            window.addEventListener('keydown', handleArrow, true);
            document.addEventListener('keydown', handleArrow, true);
        })();
    </script>
@endsection
