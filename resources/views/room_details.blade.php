@extends('layouts.app')

@section('title', $room['name'] . ' | Room Details | LCR Booking')

@section('content')
    <div class="pt-20 bg-[#0a1128] min-h-screen">
        <!-- Hero/Gallery Section -->
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="mb-8 reveal-up">
                <nav class="flex text-gray-400 text-sm mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Home</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('rooms') }}" class="hover:text-blue-400 transition-colors">Rooms</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-white">{{ $room['name'] }}</li>
                    </ol>
                </nav>
                <h1 class="text-4xl md:text-6xl font-bold text-white tracking-tighter">{{ $room['name'] }}</h1>
            </div>

            <!-- Main Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 h-[60vh] min-h-[400px] mb-12 reveal-up">
                <div class="md:col-span-2 md:row-span-2 relative group overflow-hidden rounded-2xl border border-white/10">
                    <img src="{{ $room['images'][0] ?? asset('images/rooms/room1.jpg') }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="{{ $room['name'] }}">
                </div>
                @for ($i = 1; $i < min(5, count($room['images'])); $i++)
                    <div class="relative group overflow-hidden rounded-2xl border border-white/10">
                        <img src="{{ $room['images'][$i] }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="{{ $room['name'] }} {{ $i }}">
                    </div>
                @endfor
                @if(count($room['images']) < 5)
                    @for ($i = count($room['images']); $i < 5; $i++)
                        <div
                            class="relative group overflow-hidden rounded-2xl border border-white/10 bg-blue-900/20 flex items-center justify-center">
                            <svg class="w-12 h-12 text-blue-900/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H4a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endfor
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Details Column -->
                <div class="lg:col-span-2 space-y-12">
                    <div class="reveal-up">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            About this room
                            <span class="flex-grow h-px bg-white/10"></span>
                        </h2>
                        <p class="text-gray-400 text-lg leading-relaxed">
                            {{ $room['description'] }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 reveal-up" style="--delay: 100ms">
                        <div class="bg-blue-950/30 p-6 rounded-2xl border border-blue-900/30">
                            <p class="text-blue-400 text-xs uppercase tracking-widest mb-2">Room Size</p>
                            <p class="text-white text-xl font-bold">{{ $room['area'] ?? '28' }} sqm</p>
                        </div>
                        <div class="bg-blue-950/30 p-6 rounded-2xl border border-blue-900/30">
                            <p class="text-blue-400 text-xs uppercase tracking-widest mb-2">Max Guests</p>
                            <p class="text-white text-xl font-bold">{{ ($room['adult'] ?? 2) + ($room['children'] ?? 0) }}
                                Persons</p>
                        </div>
                        <div class="bg-blue-950/30 p-6 rounded-2xl border border-blue-900/30">
                            <p class="text-blue-400 text-xs uppercase tracking-widest mb-2">Availability</p>
                            <p class="text-white text-xl font-bold">{{ $room['quantity'] ?? $room['units'] ?? 'Available' }}
                                Units</p>
                        </div>
                    </div>

                    <div class="reveal-up" style="--delay: 200ms">
                        <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                            Features & Amenities
                            <span class="flex-grow h-px bg-white/10"></span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-blue-400 text-sm font-bold uppercase tracking-widest mb-6">Room Features
                                </h3>
                                <ul class="space-y-4">
                                    @forelse($room['features'] ?? [] as $feature)
                                        <li class="flex items-center gap-3 text-gray-300">
                                            <div class="w-2 h-2 rounded-full bg-blue-600"></div>
                                            {{ $feature }}
                                        </li>
                                    @empty
                                        <li class="text-gray-500 italic">No specific features listed</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-blue-400 text-sm font-bold uppercase tracking-widest mb-6">Facilities</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    @forelse($room['facilities'] ?? [] as $facility)
                                        <div
                                            class="flex items-center gap-4 text-gray-300 bg-white/5 p-3 rounded-lg border border-white/5">
                                            @if(isset($facility['icon']))
                                                <img src="{{ asset('images/facilities/' . $facility['icon']) }}"
                                                    class="w-6 h-6 opacity-60" alt="{{ $facility['name'] }}">
                                            @else
                                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @endif
                                            {{ $facility['name'] }}
                                        </div>
                                    @empty
                                        <div class="text-gray-500 italic">No specific facilities listed</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="reveal-up" style="--delay: 300ms">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                                Guest Reviews
                                <span class="flex-grow h-px bg-white/10 w-24"></span>
                            </h2>
                            @if(count($reviews) > 0)
                                <div
                                    class="flex items-center gap-2 bg-blue-600/20 px-4 py-2 rounded-full border border-blue-500/30">
                                    <div class="flex text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-600 fill-none stroke-current' }}"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-white font-bold">{{ number_format($avgRating, 1) }}</span>
                                    <span class="text-gray-400 text-sm">({{ count($reviews) }})</span>
                                </div>
                            @endif
                        </div>

                        <!-- Status Messages -->
                        @if(session('status'))
                            <div
                                class="mb-8 p-4 bg-green-500/10 border border-green-500/30 rounded-2xl text-green-400 text-sm flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Review Form -->
                        @auth
                            <div class="bg-white/5 border border-white/10 rounded-3xl p-8 mb-12">
                                <h3 class="text-white font-bold mb-6">Leave a Review</h3>
                                <form action="{{ route('room.review', ['id' => $room['id']]) }}" method="POST">
                                    @csrf
                                    <div class="mb-6">
                                        <label class="block text-gray-400 text-sm mb-3">Your Rating</label>
                                        <div class="flex gap-2 text-3xl cursor-pointer" id="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button"
                                                    class="star-btn text-yellow-500 transition-all hover:scale-120"
                                                    data-rating="{{ $i }}">
                                                    ★
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating-input" value="5">
                                    </div>
                                    <div class="mb-6">
                                        <label class="block text-gray-400 text-sm mb-3">Your Review</label>
                                        <textarea name="review" rows="4" required
                                            class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:outline-none focus:border-blue-500 transition-all placeholder-gray-600"
                                            placeholder="Share your experience..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg shadow-blue-900/40">Post
                                        Review</button>
                                </form>
                            </div>
                        @else
                            <div class="bg-blue-950/20 border border-blue-900/30 rounded-3xl p-8 mb-12 text-center">
                                <p class="text-gray-400 mb-4 text-lg">Did you stay here?</p>
                                <p class="text-gray-500 mb-6 text-sm">Sign in to share your experience with other travelers.</p>
                                <button data-open-login-modal
                                    class="inline-block bg-white/10 border border-white/20 text-white font-bold px-10 py-3 rounded-xl hover:bg-white/20 transition-all">Sign
                                    In to Rate</button>
                            </div>
                        @endauth

                        <!-- Reviews List -->
                        <div class="space-y-6">
                            @forelse($reviews as $review)
                                <div
                                    class="bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/[0.07] transition-all">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-white font-bold">{{ $review->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex text-yellow-500 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-600 fill-none stroke-current' }}"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-300 leading-relaxed italic">"{{ $review->review }}"</p>
                                    @if(!empty($review->admin_reply))
                                        <div class="mt-4 bg-white/5 border border-white/10 rounded-xl p-4">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold shadow">
                                                    {{ strtoupper(substr(optional($review->adminUser)->name ?? 'A', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-white font-semibold text-sm">Admin Reply</p>
                                                    <p class="text-gray-500 text-xs">
                                                        {{ optional($review->admin_reply_at)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="text-gray-200 text-sm">{{ $review->admin_reply }}</p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-20 bg-blue-950/10 rounded-3xl border border-dashed border-white/10">
                                    <div
                                        class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">No reviews yet. Be the first to share your experience!
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Booking Sidebar -->
                <div class="reveal-right">
                    <div
                        class="sticky top-32 bg-blue-950/40 p-8 rounded-3xl border border-blue-800/50 backdrop-blur-xl shadow-2xl">
                        <div class="mb-8 pb-8 border-b border-white/10">
                            <p class="text-blue-400 text-sm uppercase tracking-widest mb-2">Price Starting From</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-bold text-white">₱{{ number_format($room['price'] ?? 0) }}</span>
                                <span class="text-gray-400">/ night</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4 text-gray-300 text-sm">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Instant Confirmation
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 text-sm">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Free Cancellation available
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 text-sm">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Secure Payment
                            </div>
                        </div>

                        <div class="mt-10 space-y-4">
                            <a href="{{ route('book.start', ['room_id' => $room['id']]) }}"
                                class="w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-5 rounded-xl text-sm tracking-widest uppercase transition-all shadow-lg shadow-blue-900/60">
                                Book Now
                            </a>
                            <p class="text-center text-xs text-gray-500 mt-4">
                                Taxes and fees included. No hidden charges.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Sections Placeholder or Footer CTA -->
        <div class="bg-blue-950/20 border-t border-blue-900/30 py-24 text-center px-6 mt-20">
            <h2 class="text-3xl font-bold mb-6 tracking-tight text-white reveal-up">Still deciding?</h2>
            <p class="text-blue-200/60 mb-10 max-w-xl mx-auto reveal-up" style="--delay: 120ms">
                Explore our other accommodations to find the perfect fit for your needs.
            </p>
            <a href="{{ route('rooms') }}"
                class="inline-block border border-blue-500/30 text-white font-bold px-10 py-4 rounded-md hover:bg-blue-500/10 transition-all uppercase text-sm tracking-widest reveal-up"
                style="--delay: 240ms">
                Back to All Rooms
            </a>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starBtns = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');

        starBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;

                // Update stars visual
                starBtns.forEach(sb => {
                    if (parseInt(sb.getAttribute('data-rating')) <= parseInt(rating)) {
                        sb.classList.remove('text-gray-600');
                        sb.classList.add('text-yellow-500');
                    } else {
                        sb.classList.remove('text-yellow-500');
                        sb.classList.add('text-gray-600');
                    }
                });
            });

            // Initial state (5 stars)
            if (parseInt(btn.getAttribute('data-rating')) <= 5) {
                btn.classList.add('text-yellow-500');
            }
        });
    });
</script>
@endsection
