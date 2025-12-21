<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Feed - Discover & Connect</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-mesh {
            background-color: #ffffff;
            background-image: radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
        }
    </style>
</head>
<body class="antialiased bg-mesh text-slate-900 overflow-x-hidden">

    <nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-white/70 border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
               <img src="{{ asset('images/3.png') }}" class="w-20 h-20 rounded-full object-cover" alt="Gambar">
                <span class="text-2xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                    Social Feed
                </span>
            </div>

            <div class="hidden md:flex items-center gap-8 font-medium text-slate-600">
                <a href="#features" class="hover:text-indigo-600 transition scroll-smooth">Jelajahi</a>
                <a href="#features" class="hover:text-indigo-600 transition scroll-smooth">Fitur</a>
                <a href="#community" class="hover:text-indigo-600 transition scroll-smooth">Komunitas</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-full font-semibold shadow-xl hover:bg-slate-800 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-indigo-600">Masuk</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-full font-bold shadow-lg shadow-indigo-500/30 hover:scale-105 transition-transform">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="relative pt-40 pb-20">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-bold mb-6 uppercase tracking-wider">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Update: Social Feed v2.0 Telah Rilis
                </div>
                <h1 class="text-6xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1] mb-8">
                    Ekspresikan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">Dunia Anda</span>
                </h1>
                <p class="text-xl text-slate-500 leading-relaxed mb-10 max-w-lg">
                    Platform sosial yang didesain untuk kreator, pemikir, dan penjelajah. Terhubung dengan apa yang Anda cintai.
                </p>
                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition">Mulai Petualangan</a>
                    @else
                        <a href="{{ route('register') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition">Mulai Petualangan</a>
                    @endauth
                    <a href="#features" class="px-10 py-4 bg-white border border-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-50 transition scroll-smooth">Lihat Tren</a>
                </div>
            </div>

            <div class="relative">
                <div class="relative z-10 w-full aspect-square rounded-[3rem] overflow-hidden shadow-2xl rotate-3 border-8 border-white">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80" alt="Community" class="w-full h-full object-cover">
                </div>
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse transition-delay-1000"></div>
            </div>
        </div>

        <!-- Features Section -->
        <section id="features" class="py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">
                        Fitur Unggulan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">Social Feed</span>
                    </h2>
                    <p class="text-xl text-slate-500 max-w-3xl mx-auto">
                        Temukan semua yang Anda butuhkan untuk terhubung, berbagi, dan berkreasi di platform sosial modern.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 hover:shadow-2xl transition-shadow">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Posting Interaktif</h3>
                        <p class="text-slate-600">Bagikan cerita, foto, dan video dengan komunitas Anda. Dapatkan engagement real-time.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 hover:shadow-2xl transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Chat Real-time</h3>
                        <p class="text-slate-600">Terhubung dengan teman-teman Anda melalui pesan instan yang aman dan privat.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 hover:shadow-2xl transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Stories Ephemeral</h3>
                        <p class="text-slate-600">Bagikan momen singkat yang hilang dalam 24 jam. Buat konten yang lebih autentik.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 hover:shadow-2xl transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Pencarian Canggih</h3>
                        <p class="text-slate-600">Temukan orang, postingan, dan tren terbaru dengan fitur pencarian yang powerful.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 hover:shadow-2xl transition-shadow">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Like & Comment</h3>
                        <p class="text-slate-600">Berikan apresiasi dan mulai diskusi dengan fitur like dan komentar yang interaktif.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100 hover:shadow-2xl transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Privasi & Keamanan</h3>
                        <p class="text-slate-600">Data Anda aman dengan enkripsi end-to-end dan kontrol privasi yang lengkap.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Community Section -->
        <section id="community" class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">
                        Bergabung dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">Komunitas</span>
                    </h2>
                    <p class="text-xl text-slate-500 max-w-3xl mx-auto">
                        Ribuan kreator, pemikir, dan penjelajah telah bergabung. Sekarang giliran Anda untuk menjadi bagian dari cerita mereka.
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-slate-900 mb-6">Apa Kata Mereka?</h3>
                        <div class="space-y-6">
                            <div class="bg-white rounded-xl p-6 shadow-lg border border-slate-100">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        A
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">Ahmad Rahman</h4>
                                        <p class="text-sm text-slate-500">Content Creator</p>
                                    </div>
                                </div>
                                <p class="text-slate-600">"Social Feed telah mengubah cara saya berinteraksi dengan audience. Fitur-fitur yang intuitif membuat proses kreatif jadi lebih menyenangkan!"</p>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-lg border border-slate-100">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                        S
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">Sari Dewi</h4>
                                        <p class="text-sm text-slate-500">Digital Marketer</p>
                                    </div>
                                </div>
                                <p class="text-slate-600">"Platform yang sangat user-friendly. Analytics dan engagement tools-nya membantu saya memahami audience dengan lebih baik."</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-100">
                            <h3 class="text-2xl font-bold text-slate-900 mb-6">Statistik Komunitas</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <div class="text-3xl font-extrabold text-indigo-600 mb-2">50K+</div>
                                    <div class="text-slate-600">Pengguna Aktif</div>
                                </div>
                                <div>
                                    <div class="text-3xl font-extrabold text-purple-600 mb-2">1M+</div>
                                    <div class="text-slate-600">Postingan</div>
                                </div>
                                <div>
                                    <div class="text-3xl font-extrabold text-green-600 mb-2">500+</div>
                                    <div class="text-slate-600">Komunitas</div>
                                </div>
                                <div>
                                    <div class="text-3xl font-extrabold text-orange-600 mb-2">24/7</div>
                                    <div class="text-slate-600">Support</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">
                    Siap untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">Bergabung?</span>
                </h2>
                <p class="text-xl text-slate-500 mb-10">
                    Mulai perjalanan Anda di Social Feed hari ini. Gratis untuk mendaftar dan mulai terhubung.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="px-10 py-4 bg-white border border-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-50 transition">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/3.png') }}" class="w-12 h-12 rounded-full object-cover" alt="Logo">
                        <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                            Social Feed
                        </span>
                    </div>
                    <p class="text-slate-400 mb-6">
                        Platform sosial modern untuk kreator, pemikir, dan penjelajah di era digital.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-slate-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-slate-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-slate-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-6">Produk</h3>
                    <ul class="space-y-3 text-slate-400">
                        <li><a href="#features" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-white transition">Keamanan</a></li>
                        <li><a href="#" class="hover:text-white transition">Enterprise</a></li>
                        <li><a href="#" class="hover:text-white transition">API</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-6">Komunitas</h3>
                    <ul class="space-y-3 text-slate-400">
                        <li><a href="#community" class="hover:text-white transition">Bergabung</a></li>
                        <li><a href="#" class="hover:text-white transition">Forum</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Events</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-lg mb-6">Support</h3>
                    <ul class="space-y-3 text-slate-400">
                        <li><a href="#" class="hover:text-white transition">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition">Status</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 text-center text-slate-400">
                <p>&copy; 2025 Social Feed. All rights reserved. Made with ❤️ for creators worldwide.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
            observer.observe(card);
        });

        // Add CSS animation class
        const style = document.createElement('style');
        style.textContent = `
            .animate-fade-in {
                animation: fadeInUp 0.6s ease-out forwards;
            }
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>