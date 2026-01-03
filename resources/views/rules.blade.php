@extends('layouts.app')

@section('title', 'Rules & Regulations | LCR Booking')

@section('content')
    <div class="pt-20 bg-[#0a1128] min-h-screen">
        <div class="max-w-4xl mx-auto px-6 py-24">
            <h1 class="text-4xl md:text-5xl font-bold mb-8 tracking-tight text-white mb-12 text-center">Rules & Regulations
            </h1>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 md:p-8 shadow-2xl">
                @php
                    $rulesImgPath = null;
                    foreach (['rules.jpg','rules.png','rules.webp'] as $f) {
                        $p = public_path('images/'.$f);
                        if (file_exists($p)) {
                            $rulesImgPath = asset('images/'.$f).'?v='.@filemtime($p);
                            break;
                        }
                    }
                @endphp
                @if($rulesImgPath)
                    <img src="{{ $rulesImgPath }}" class="w-full h-auto max-h-[80vh] rounded-lg object-contain" alt="Rules and Regulations">
                @else
                    <div class="text-center py-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-400">Rules and Regulations content is currently being updated. Please check back
                            later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
