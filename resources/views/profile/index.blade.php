<x-app-layout>
    {{-- Style Tambahan untuk Scrollbar & Upload Button --}}
    @push('styles')
    <style>
        .profile-upload-btn { cursor: pointer; }
        .profile-upload-input { display: none; }
    </style>
    @endpush

    {{-- Main Background: Terang (Gray-100) --}}
    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-white">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- PROFILE HEADER CARD --}}
            {{-- Card Background: Putih --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                
                {{-- 1. COVER IMAGE SECTION --}}
                <div class="relative h-[300px] bg-gray-300 dark:bg-gray-600">
                    @if ($user->cover_image)
                        <img src="{{ asset('storage/'.$user->cover_image) }}" class="w-full h-full object-cover">
                    @else
                        {{-- Gradient Terang --}}
                        <div class="w-full h-full bg-gradient-to-r from-gray-300 dark:from-gray-600 to-gray-200 dark:to-gray-500"></div>
                    @endif

                    {{-- Tombol Update Cover --}}
                    {{-- Note: Tetap gelap transparan agar kontras dengan foto cover --}}
                    @if (Auth::id() === $user->id)
                        <form action="{{ route('profile.updateImages') }}" method="POST" enctype="multipart/form-data" class="absolute top-4 right-4">
                            @csrf
                            <label for="cover_upload" class="bg-black/50 hover:bg-black/70 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-md text-sm font-medium flex items-center gap-2 transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                <span>Edit Cover</span>
                            </label>
                            <input type="file" id="cover_upload" name="cover_image" class="hidden" onchange="this.form.submit()">
                        </form>
                    @endif
                </div>

                {{-- 2. PROFILE INFO SECTION --}}
                <div class="px-8 pb-6 relative">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 mb-4 gap-6">
                        
                        {{-- Foto Profil --}}
                        <div class="relative group">
                            {{-- Border diubah menjadi putih (border-white) agar menyatu dengan card --}}
                            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-[5px] border-white bg-gray-200 overflow-hidden relative z-10 shadow-sm">
                                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-full h-full object-cover">
                            </div>
                            
                            {{-- Tombol Update Avatar --}}
                            @if (Auth::id() === $user->id)
                                <form action="{{ route('profile.updateImages') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- Tombol diedit jadi terang --}}
                                    <label for="avatar_upload" class="absolute bottom-2 right-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 p-2 rounded-full border border-gray-300 dark:border-gray-600 z-20 transition cursor-pointer shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    </label>
                                    <input type="file" id="avatar_upload" name="avatar" class="hidden" onchange="this.form.submit()">
                                </form>
                            @endif
                        </div>

                        {{-- Nama & Info --}}
                        <div class="flex-1 mt-2 md:mt-0 md:pb-4 text-center md:text-left">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                {{ $user->username }} 
                                • {{ $user->posts->count() }} Post(s)
                            </p> 
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-3 md:pb-6 w-full md:w-auto justify-center">
                            @if (Auth::id() === $user->id)
                                {{-- Tombol Edit Profile --}}
                                <a href="{{ route('profile.edit') }}" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-md font-semibold transition flex items-center gap-2 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Edit Profile
                                </a>
                            @else
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition shadow-sm">
                                    Follow
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                    {{-- Navigation Tabs --}}
                    <nav class="flex space-x-2 justify-center md:justify-start overflow-x-auto">
                        @foreach(['Posts', 'About', 'Friends', 'Photos'] as $tab)
                            @if($tab === 'About' && Auth::id() === $user->id)
                                <a href="{{ route('profile.edit') }}" class="px-4 py-3 font-semibold text-sm rounded-md transition whitespace-nowrap {{ $tab === 'Posts' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                    {{ $tab }}
                                </a>
                            @else
                                <a href="#" class="px-4 py-3 font-semibold text-sm rounded-md transition whitespace-nowrap {{ $tab === 'Posts' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                    {{ $tab }}
                                </a>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- CONTENT GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Sidebar (Intro) --}}
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow border border-gray-200 dark:border-gray-700">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-3">Intro</h3>
                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        @if($user->job_title || $user->company)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>{{ $user->job_title ?? 'User' }} @if($user->company) at <strong>{{ $user->company }}</strong>@endif</span>
                            </div>
                        @endif
                        @if($user->location)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>From <strong>{{ $user->location }}</strong></span>
                            </div>
                        @endif
                        @if($user->education)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                <span>Studied at <strong>{{ $user->education }}</strong></span>
                            </div>
                        @endif
                        @if($user->phone)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>{{ $user->phone }}</span>
                            </div>
                        @endif
                        @if($user->address)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>Lives in <strong>{{ $user->address }}</strong></span>
                            </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Joined {{ $user->created_at->format('F Y') }}</span>
                        </div>
                        @if($user->bio)
                            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>

                {{-- Main Feed (Posts) --}}
                <div class="lg:col-span-2 space-y-5">
                    
                    {{-- Create Post Trigger --}}
                    @if (Auth::id() === $user->id)
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow border border-gray-200 dark:border-gray-700 flex items-center gap-3">
                            <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                            {{-- Input dibuat abu-abu terang --}}
                            <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 dark:bg-gray-700 border border-transparent hover:border-gray-300 dark:hover:border-gray-600 rounded-full px-4 py-2 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600 transition text-left text-sm">
                                What's on your mind, {{ Auth::user()->name }}?
                            </a>
                        </div>
                    @endif

                    {{-- Loop User Posts --}}
                    @forelse($user->posts()->latest()->get() as $post)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-4">
                            {{-- Header Post --}}
                            <div class="flex items-center space-x-3 mb-3">
                                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $user->name }}</h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            {{-- Body Post --}}
                            <div class="text-gray-800 dark:text-gray-200 text-sm mb-3 whitespace-pre-line">
                                {!! $post->body !!}
                            </div>

                            {{-- Attachments --}}
                            @if ($post->attachments->count() > 0)
                                <div class="grid grid-cols-2 gap-1 rounded-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                                    @foreach ($post->attachments as $attachment)
                                        @if (Str::startsWith($attachment->mime_type, 'image/'))
                                            <img src="{{ asset('storage/' . $attachment->path) }}" class="w-full h-48 object-cover hover:opacity-95 transition">
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-800 p-10 rounded-xl shadow border border-gray-200 dark:border-gray-700 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No posts</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This user hasn't posted anything yet.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>