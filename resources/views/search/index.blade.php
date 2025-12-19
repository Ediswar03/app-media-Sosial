<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Hasil pencarian: <span class="text-indigo-600">"{{ $query }}"</span>
                </h2>
                <span class="text-sm text-gray-500">
                    {{ $users->count() + $posts->count() }} hasil ditemukan
                </span>
            </div>

            @if($users->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl mb-8 border border-gray-100 dark:border-gray-700">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300 text-sm uppercase tracking-wider">Akun Ditemukan</h3>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($users as $user)
                            <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-3">
                                    <div class="shrink-0">
                                        @if($user->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ '@' . $user->username }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('profile.index', $user->username ?? $user->id) }}" class="px-3 py-1 text-xs font-semibold text-indigo-600 border border-indigo-200 rounded-full hover:bg-indigo-50 transition">
                                    Lihat Profil
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($posts->count() > 0)
                <div class="space-y-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 ml-1">Postingan Terkait</h3>
                    
                    @foreach($posts as $post)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('profile.index', $post->user->username ?? $post->user->id) }}" class="shrink-0 group">
                                            @if($post->user->avatar)
                                                <img class="h-10 w-10 rounded-full object-cover border border-gray-200 group-hover:opacity-80 transition" src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 font-bold group-hover:bg-gray-300 transition">
                                                    {{ substr($post->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </a>
                                        <div>
                                            <a href="{{ route('profile.index', $post->user->username ?? $post->user->id) }}" class="font-bold text-gray-900 dark:text-gray-100 hover:underline text-sm">
                                                {{ $post->user->name }}
                                            </a>
                                            <div class="text-xs text-gray-500 flex items-center">
                                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-gray-800 dark:text-gray-200 text-[15px] leading-relaxed mb-3 whitespace-pre-wrap break-words">
                                    {{ $post->body }}
                                </div>

                                @if(isset($post->image) && $post->image)
                                    <div class="mt-3 mb-2">
                                        <img src="{{ asset('storage/' . $post->image) }}" 
                                             class="w-full h-auto rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm object-cover max-h-[500px]" 
                                             alt="Post Image"
                                             loading="lazy">
                                    </div>
                                @endif

                                <div class="mt-4 pt-3 border-t border-gray-50 dark:border-gray-700 flex items-center text-gray-500 text-sm">
                                    <div class="flex items-center space-x-1 text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <span class="text-xs font-medium">Hasil Pencarian</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($users->isEmpty() && $posts->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-12 text-center border border-gray-100 dark:border-gray-700">
                    <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Tidak ditemukan hasil</h3>
                    <p class="text-gray-500 mt-2 max-w-sm mx-auto">
                        Kami tidak dapat menemukan pengguna atau postingan yang mengandung kata kunci <span class="font-semibold">"{{ $query }}"</span>.
                    </p>
                    <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali ke Dashboard
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>