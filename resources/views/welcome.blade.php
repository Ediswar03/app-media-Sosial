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
                <a href="#" class="hover:text-indigo-600 transition">Jelajahi</a>
                <a href="#" class="hover:text-indigo-600 transition">Fitur</a>
                <a href="#" class="hover:text-indigo-600 transition">Komunitas</a>
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
                    <button class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 transition">Mulai Petualangan</button>
                    <button class="px-10 py-4 bg-white border border-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-50 transition">Lihat Tren</button>
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
    </main>
</body>
</html>