<x-app-layout>
    {{-- Trix Editor CSS & JS --}}
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    @endpush

    {{-- Style Tambahan Custom --}}
    <style>
        /* Trix Customization */
        .trix-button-group--file-tools { display: none !important; }
        trix-toolbar .trix-button-group { margin-bottom: 5px !important; }
        trix-editor { border: 1px solid #e5e7eb !important; border-radius: 0.5rem; padding: 10px !important; min-height: 100px; max-height: 200px; overflow-y: auto; background-color: white; }
        .dark trix-editor { background-color: #374151 !important; border-color: #4b5563 !important; color: #f3f4f6 !important; }
        trix-editor:empty:not(:focus)::before { color: #9ca3af; }
        .dark trix-editor:empty:not(:focus)::before { color: #6b7280; }
        
        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        [x-cloak] { display: none !important; }
    </style>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-white" x-data="{ createModalOpen: false }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- 0. FLASH MESSAGE --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            {{-- 1. TRIGGER FORM CREATE POST --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm mb-6 border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                 @click="createModalOpen = true">
                <div class="flex space-x-3 items-center">
                    {{-- FIX AVATAR --}}
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" 
                         class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0">
                    
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full px-5 py-2.5 text-gray-500 dark:text-gray-400 text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition text-left truncate">
                        Apa yang Anda pikirkan, {{ Auth::user()->name }}?
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-3 flex justify-between px-2">
                    <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                        <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="currentColor"><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.41 0 .75.34.75.75v15.5c0 .41-.34.75-.75.75H4.25c-.41 0-.75-.34-.75-.75V4.25c0-.41.34-.75.75-.75zm7.47 3.86c1.17 0 2.13.96 2.13 2.13 0 1.17-.96 2.13-2.13 2.13-1.17 0-2.13-.96-2.13-2.13 0-1.17.96-2.13 2.13-2.13zM6 17h12l-3.75-5-2.5 3.25-1.5-1.87L6 17z"/></svg>
                        <span>Foto/Video</span>
                    </div>
                </div>
            </div>

            {{-- MODAL CREATE POST (Pop Up) --}}
            <div x-show="createModalOpen" style="display: none;" 
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
                 x-transition.opacity
                 x-cloak>
                <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-xl shadow-2xl overflow-hidden transform transition-all" @click.away="createModalOpen = false">
                    <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex justify-between items-center bg-gray-50 dark:bg-gray-700">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200 text-center flex-1">Buat Postingan</h3>
                        <button @click="createModalOpen = false" class="p-1.5 bg-gray-200 dark:bg-gray-600 rounded-full hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-600 dark:text-gray-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="p-4 max-h-[80vh] overflow-y-auto">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex items-center space-x-3 mb-4">
                                {{-- FIX AVATAR --}}
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" 
                                     class="w-10 h-10 rounded-full object-cover">
                                <div><h4 class="font-bold text-gray-900">{{ Auth::user()->name }}</h4></div>
                            </div>
                            <input id="body-create" type="hidden" name="body">
                            <trix-editor input="body-create" class="trix-content text-gray-800 min-h-[120px]" placeholder="Apa yang Anda pikirkan?"></trix-editor>
                            <div id="media-preview-container" class="grid grid-cols-2 gap-2 mt-3 hidden rounded-lg overflow-hidden border border-gray-200"></div>
                            <div class="border border-gray-200 rounded-lg p-3 mt-4 flex items-center justify-between shadow-sm bg-gray-50">
                                <span class="text-sm font-semibold text-gray-600">Tambahkan ke postingan</span>
                                <div class="flex items-center">
                                    <input type="file" id="attachments" name="attachments[]" multiple accept="image/*,video/*" class="hidden">
                                    <label for="attachments" class="cursor-pointer p-2 hover:bg-gray-200 rounded-full transition tooltip" title="Foto/Video">
                                        <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="currentColor"><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.41 0 .75.34.75.75v15.5c0 .41-.34.75-.75.75H4.25c-.41 0-.75-.34-.75-.75V4.25c0-.41.34-.75.75-.75zm7.47 3.86c1.17 0 2.13.96 2.13 2.13 0 1.17-.96 2.13-2.13 2.13-1.17 0-2.13-.96-2.13-2.13 0-1.17.96-2.13 2.13-2.13zM6 17h12l-3.75-5-2.5 3.25-1.5-1.87L6 17z"/></svg>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-bold text-sm mt-4 shadow transition">Posting</button>
                        </form>
                    </div>
                </div>
            </div>
            

            {{-- 2. LIST POST --}}
            @forelse ($posts as $post)
                {{-- Note: Menambahkan 'editModalOpen: false' di x-data agar setiap post punya kontrol modal sendiri --}}
                <div x-data="{ openComment: false, openMenu: false, editModalOpen: false }" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm mb-5 pb-2 border border-gray-200 dark:border-gray-700 overflow-visible">
                    
                    {{-- A. Header Post --}}
                    <div class="flex justify-between items-start px-4 pt-4 mb-2">
                        <div class="flex items-center space-x-3">
                            {{-- FIX AVATAR --}}
                            <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=random' }}"
                                 class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            
                            <div class="flex flex-col leading-tight">
                                <div class="flex items-center">
                                    <h4 class="font-bold text-gray-900 text-[15px] hover:underline cursor-pointer">{{ $post->user->name }}</h4>
                                    
                                    {{-- Tombol Ikuti --}}
                                    @if(Auth::id() !== $post->user->id)
                                        <button 
                                            onclick="toggleFollow(this, {{ $post->user->id }})"
                                            data-url="{{ route('users.follow', $post->user) }}"
                                            id="follow-btn-{{ $post->user->id }}"
                                            class="text-[15px] font-bold ml-1 transition {{ $post->user->isFollowedBy(Auth::user()) ? 'text-gray-500 hover:text-red-500' : 'text-blue-600 hover:text-blue-800' }}">
                                        {{ $post->user->isFollowedBy(Auth::user()) ? '• Mengikuti' : '• Ikuti' }}
                                        </button>
                                    @endif
                                </div>
                                <div class="flex items-center text-gray-500 text-[13px] font-normal mt-0.5">
                                    <span>{{ $post->created_at->diffForHumans() }}</span> 
                                    <span class="mx-1">&bull;</span>
                                    <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- MENU OPSI (Titik Tiga) --}}
                        <div class="relative">
                            <button @click="openMenu = !openMenu" class="p-2 hover:bg-gray-100 rounded-full transition text-gray-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm12 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                            
                            {{-- Dropdown Menu --}}
                            <div x-show="openMenu" @click.away="openMenu = false" 
                                 class="absolute right-0 top-10 w-56 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-20 overflow-hidden" 
                                 x-transition.origin.top.right 
                                 x-cloak>
                                
                                {{-- 1. Edit Postingan --}}
                                @if(Auth::id() === $post->user_id)
                                    <button @click="editModalOpen = true; openMenu = false" class="w-full flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition text-left">
                                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit postingan
                                    </button>
                                @endif

                                {{-- 2. Salin Tautan --}}
                                <button onclick="copyToClipboard('{{ route('dashboard') }}')" class="w-full flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition text-left">
                                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Salin tautan
                                </button>

                                {{-- 3. Hapus Postingan --}}
                                @if (Auth::id() === $post->user_id || Auth::user()->role === 'admin')
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus postingan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- B. Post Content --}}
                    <div class="px-4 mb-3 text-gray-900 dark:text-white text-[15px] leading-relaxed break-words trix-content">
                        {!! $post->body !!}
                    </div>

                    {{-- C. Images / Videos --}}
                    @if ($post->attachments->count() > 0)
                        <div class="w-full bg-black cursor-pointer overflow-hidden relative">
                            <div class="{{ $post->attachments->count() > 1 ? 'grid grid-cols-2 gap-0.5' : '' }}">
                                @foreach ($post->attachments as $index => $attachment)
                                    @if($index < 4) 
                                        <div class="relative w-full h-full bg-gray-100">
                                            @if (\Illuminate\Support\Str::startsWith($attachment->mime_type, 'image/'))
                                                <img src="{{ asset('storage/' . $attachment->path) }}" class="w-full h-auto object-cover max-h-[500px] min-h-[250px] aspect-square">
                                            @elseif(\Illuminate\Support\Str::startsWith($attachment->mime_type, 'video/'))
                                                <video controls class="w-full h-auto object-cover max-h-[500px] min-h-[250px] aspect-square">
                                                    <source src="{{ asset('storage/' . $attachment->path) }}" type="{{ $attachment->mime_type }}">
                                                </video>
                                            @endif
                                            @if($index === 3 && $post->attachments->count() > 4)
                                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold text-2xl">
                                                    +{{ $post->attachments->count() - 4 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- D. Stats --}}
                    <div class="px-4 py-3 flex items-center justify-between text-gray-500 dark:text-gray-400 text-sm">
                        <div class="flex items-center cursor-pointer hover:underline">
                            <div class="bg-blue-500 rounded-full p-1 mr-1.5 flex items-center justify-center w-4 h-4 shadow-sm" x-show="document.getElementById('like-count-{{ $post->id }}').innerText > 0">
                                <svg class="w-2.5 h-2.5 text-white fill-current" viewBox="0 0 24 24"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                            </div>
                            <span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>
                        </div>
                        <div class="cursor-pointer hover:underline" @click="openComment = true">
                            {{ $post->comments->count() }} Komentar
                        </div>
                    </div>

                    {{-- E. Action Buttons --}}
                    <div class="px-4 border-t border-gray-200">
                        <div class="flex items-center justify-between py-1">
                            {{-- Like --}}
                            <button onclick="toggleLike(this, {{ $post->id }})" data-url="{{ route('posts.like', $post) }}" id="like-btn-{{ $post->id }}"
                                    class="flex-1 flex items-center justify-center py-2 hover:bg-gray-100 rounded-lg transition {{ $post->isLikedBy(Auth::user()) ? 'text-blue-600' : 'text-gray-600' }}">
                                <svg id="like-icon-{{ $post->id }}" class="w-5 h-5 mr-2 {{ $post->isLikedBy(Auth::user()) ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                <span class="font-semibold text-sm">Suka</span>
                            </button>

                            {{-- Comment --}}
                            <button @click="openComment = true" class="flex-1 flex items-center justify-center py-2 hover:bg-gray-100 rounded-lg transition text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                <span class="font-semibold text-sm">Komentar</span>
                            </button>

                            {{-- Share --}}
                            <button onclick="sharePost('Postingan {{ $post->user->name }}', '{{ route('dashboard') }}')" class="flex-1 flex items-center justify-center py-2 hover:bg-gray-100 rounded-lg transition text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                <span class="font-semibold text-sm">Bagikan</span>
                            </button>
                        </div>
                    </div>

                    {{-- F. MODAL POP-UP KOMENTAR --}}
                    <div x-show="openComment" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 animate-fade-in" x-transition.opacity x-cloak>
                        <div class="bg-white w-full max-w-lg h-[85vh] rounded-xl shadow-2xl flex flex-col relative" @click.away="openComment = false">
                            <div class="border-b border-gray-200 px-4 py-3 flex justify-between items-center bg-white rounded-t-xl z-10">
                                <h3 class="font-bold text-lg text-gray-800 text-center flex-1">Komentar</h3>
                                <button @click="openComment = false" class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 transition"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </div>
                            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                                @forelse ($post->comments as $comment)
                                    <div class="flex space-x-2">
                                        {{-- FIX AVATAR --}}
                                        <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random' }}" class="w-9 h-9 rounded-full border border-gray-200 mt-1 object-cover">
                                        <div class="flex-1">
                                            <div class="bg-gray-100 rounded-2xl px-3 py-2 inline-block">
                                                <div class="font-bold text-[13px] text-gray-900">{{ $comment->user->name }}</div>
                                                <div class="text-[14px] text-gray-800 leading-snug">{{ $comment->content }}</div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 ml-1">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-400 mt-10">Belum ada komentar.</div>
                                @endforelse
                            </div>
                            
                            {{-- Form Komentar --}}
                            <div class="border-t border-gray-200 p-3 bg-white rounded-b-xl">
                                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    {{-- FIX AVATAR --}}
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                                    <div class="flex-1 relative">
                                        <input type="text" name="content" required placeholder="Tulis komentar..." class="w-full bg-gray-100 text-gray-800 rounded-full border-none focus:ring-0 px-4 py-2.5 text-sm placeholder-gray-500 focus:bg-gray-50 transition pr-10">
                                        <button type="submit" class="absolute right-2 top-1.5 text-blue-600 hover:bg-blue-100 p-1.5 rounded-full transition transform hover:scale-110">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path></svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- G. MODAL EDIT POST --}}
                    @if(Auth::id() === $post->user_id)
                    <div x-show="editModalOpen" style="display: none;" 
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
                         x-transition.opacity x-cloak>
                        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden transform transition-all" @click.away="editModalOpen = false">
                            <div class="border-b border-gray-200 px-4 py-3 flex justify-between items-center bg-gray-50">
                                <h3 class="font-bold text-lg text-gray-800 text-center flex-1">Edit Postingan</h3>
                                <button @click="editModalOpen = false" class="p-1.5 bg-gray-200 rounded-full hover:bg-gray-300 text-gray-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-4 max-h-[80vh] overflow-y-auto">
                                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="flex items-center space-x-3 mb-4">
                                        {{-- FIX AVATAR --}}
                                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" class="w-10 h-10 rounded-full object-cover">
                                        <div><h4 class="font-bold text-gray-900">{{ Auth::user()->name }}</h4></div>
                                    </div>
                                    
                                    <input id="edit-body-{{ $post->id }}" type="hidden" name="body" value="{!! $post->body !!}">
                                    <trix-editor input="edit-body-{{ $post->id }}" class="trix-content text-gray-800 min-h-[120px]"></trix-editor>

                                    <div class="border border-gray-200 rounded-lg p-3 mt-4 flex items-center justify-between shadow-sm bg-gray-50">
                                        <span class="text-sm font-semibold text-gray-600">Tambah file baru?</span>
                                        <div class="flex items-center">
                                            <input type="file" id="edit-attachments-{{ $post->id }}" name="attachments[]" multiple accept="image/*,video/*" class="hidden">
                                            <label for="edit-attachments-{{ $post->id }}" class="cursor-pointer p-2 hover:bg-gray-200 rounded-full transition tooltip">
                                                <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="currentColor"><path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.41 0 .75.34.75.75v15.5c0 .41-.34.75-.75.75H4.25c-.41 0-.75-.34-.75-.75V4.25c0-.41.34-.75.75-.75zm7.47 3.86c1.17 0 2.13.96 2.13 2.13 0 1.17-.96 2.13-2.13 2.13-1.17 0-2.13-.96-2.13-2.13 0-1.17.96-2.13 2.13-2.13zM6 17h12l-3.75-5-2.5 3.25-1.5-1.87L6 17z"/></svg>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-bold text-sm mt-4 shadow transition">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            @empty
                <div class="text-center p-10 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">Belum ada postingan</h3>
                </div>
            @endforelse

            <div class="mt-4 mb-10">{{ $posts->links() }}</div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script>
        // SCRIPT PREVIEW (Hanya untuk Create Modal Utama)
        const attachmentInput = document.getElementById('attachments');
        const previewContainer = document.getElementById('media-preview-container');

        if(attachmentInput) {
            attachmentInput.addEventListener('change', function(event) {
                previewContainer.innerHTML = '';
                const files = event.target.files;
                if (files.length > 0) {
                    previewContainer.classList.remove('hidden');
                    Array.from(files).forEach(file => {
                        const mediaWrapper = document.createElement('div');
                        mediaWrapper.className = 'relative aspect-square bg-gray-100 rounded border border-gray-200 overflow-hidden';
                        if (file.type.match('image.*')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'w-full h-full object-cover';
                                mediaWrapper.appendChild(img);
                                previewContainer.appendChild(mediaWrapper);
                            }
                            reader.readAsDataURL(file);
                        } else if (file.type.match('video.*')) {
                            const video = document.createElement('video');
                            video.className = 'w-full h-full object-cover';
                            video.src = URL.createObjectURL(file);
                            mediaWrapper.appendChild(video);
                            previewContainer.appendChild(mediaWrapper);
                        }
                    });
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        }

        // COPY TO CLIPBOARD
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => alert('Tautan berhasil disalin!')).catch(err => console.error('Gagal:', err));
        }

        // WEB SHARE API
        function sharePost(title, url) {
            if (navigator.share) {
                navigator.share({ title: title, url: url }).catch(console.error);
            } else {
                copyToClipboard(url);
            }
        }

        // TOGGLE LIKE
        async function toggleLike(button, postId) {
            const url = button.dataset.url;
            const likeCountSpan = document.getElementById(`like-count-${postId}`);
            const likeIcon = document.getElementById(`like-icon-${postId}`);
            const likeButton = document.getElementById(`like-btn-${postId}`);

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // Update like count
                likeCountSpan.innerText = data.likes_count;

                // Toggle button appearance
                if (data.is_liked) {
                    likeButton.classList.add('text-blue-600');
                    likeButton.classList.remove('text-gray-600');
                    likeIcon.classList.add('fill-current');
                    likeIcon.classList.remove('fill-none', 'stroke-current');
                } else {
                    likeButton.classList.remove('text-blue-600');
                    likeButton.classList.add('text-gray-600');
                    likeIcon.classList.remove('fill-current');
                    likeIcon.classList.add('fill-none', 'stroke-current');
                }

            } catch (error) {
                console.error('Error toggling like:', error);
                alert('Gagal mengubah status suka. Silakan coba lagi.');
            }
        }
    </script>
    @endpush
</x-app-layout>