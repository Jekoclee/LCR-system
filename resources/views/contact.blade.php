@extends('layouts.app')

@section('title', 'Contact Us | LCR Booking')

@section('content')
    <div class="pt-20 bg-[#0a1128] min-h-screen">
        <div class="py-20 text-center text-white mb-12 border-b border-blue-900/30">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">Contact Us</h1>
            <p class="text-xl text-blue-200/80 max-w-2xl mx-auto">Get in touch with us for any inquiries or assistance</p>
        </div>

        <div class="max-w-7xl mx-auto px-6 pb-12">

            @if(session('status'))
                <div class="mb-8 p-4 rounded-xl bg-green-600/15 border border-green-500/30 text-green-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <!-- Contact Info Card -->
                <div class="bg-black/20 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/10 p-8">
                    <h3 class="text-2xl font-bold text-white mb-8">Get in touch</h3>

                    <div class="space-y-8">
                        <!-- Address -->
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-white/10 p-3 rounded-xl text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">Address</h4>
                                <a href="{{ $contact['google_map'] ?? '#' }}" target="_blank"
                                    class="text-blue-200/80 hover:text-blue-300 transition-colors mt-1 block">
                                    {{ $contact['address'] ?? 'Address not available' }}
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-white/10 p-3 rounded-xl text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329 .423 .445 .974 .315 1.494l-.547 2.19a.678 .678 0 0 0 .178 .643l2.457 2.457a.678 .678 0 0 0 .644 .178l2.189-.547a1.745 1.745 0 0 1 1.494 .315l2.306 1.794c.829 .645 .905 1.87 .163 2.611l-1.034 1.034c-.74 .74 -1.846 1.065 -2.877 .702a18.634 18.634 0 0 1 -7.01 -4.42 18.634 18.634 0 0 1 -4.42 -7.009c-.362 -1.03 -.037 -2.137 .703 -2.877L1.885 .511z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">Call us</h4>
                                <a href="tel:+{{ $contact['pn1'] ?? '' }}"
                                    class="text-blue-200/80 hover:text-blue-300 transition-colors mt-1 block font-medium">
                                    +{{ $contact['pn1'] ?? '' }}
                                </a>
                                @if(!empty($contact['pn2']))
                                    <a href="tel:+{{ $contact['pn2'] }}"
                                        class="text-blue-200/80 hover:text-blue-300 transition-colors block font-medium">
                                        +{{ $contact['pn2'] }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-white/10 p-3 rounded-xl text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808 -1.144l-6.57 -4.027L8 9.586l-1.239 -.757Zm3.436 -.586L16 11.801V4.697l-5.803 3.546Z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">Email</h4>
                                <a href="mailto:{{ $contact['email'] ?? '' }}"
                                    class="text-blue-200/80 hover:text-blue-300 transition-colors mt-1 block">
                                    {{ $contact['email'] ?? 'info@lcrbooking.com' }}
                                </a>
                            </div>
                        </div>

                        <!-- Social -->
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-white/10 p-3 rounded-xl text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0 -3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1 -.488 .876l-6.718 -3.12a2.5 2.5 0 1 1 0 -3.256l6.718 -3.12A2.5 2.5 0 0 1 11 2.5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white">Follow us</h4>
                                <div class="flex gap-4 mt-2">
                                    <a href="{{ $contact['fb'] ?? '#' }}" target="_blank"
                                        class="text-blue-200/80 hover:text-blue-300 transition-colors flex items-center gap-1 font-medium">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                    <span class="text-white/30">|</span>
                                    <a href="{{ $contact['insta'] ?? '#' }}" target="_blank"
                                        class="text-blue-200/80 hover:text-blue-300 transition-colors flex items-center gap-1 font-medium">
                                        <i class="bi bi-instagram"></i> Instagram
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Card -->
                <div class="bg-black/20 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/10 p-8">
                    <h3 class="text-2xl font-bold text-white mb-6">Send us a message</h3>
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-white">Name</label>
                            <input type="text" name="name"
                                class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-all font-medium"
                                placeholder="Your Name" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-white">Email</label>
                            <input type="email" name="email"
                                class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-all font-medium"
                                placeholder="Your Email" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-white">Subject</label>
                            <input type="text" name="subject"
                                class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-all font-medium"
                                placeholder="Message Subject" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-white">Message</label>
                            <textarea name="message" rows="4"
                                class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-all font-medium resize-none"
                                placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" name="send"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-900/40 transition-all transform hover:scale-[1.01] active:scale-[0.99]">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Google Map -->
            <div class="mt-12 bg-black/20 p-2 rounded-2xl shadow-2xl border border-white/10">
                <div class="rounded-xl overflow-hidden h-[450px]">
                    <iframe src="{{ $contact['iframe'] ?? '' }}" class="w-full h-full border-0" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </div>
    </div>
@endsection
