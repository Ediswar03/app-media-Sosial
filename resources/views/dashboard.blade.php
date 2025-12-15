<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border border-gray-200">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="body" placeholder="Apa yang Anda pikirkan, {{ Auth::user()->name }}?" 
                        class="w-full border-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md text-lg transition duration-200" 
                        rows="3" required></textarea>
                    <div class="flex justify-end mt-3">
                        <x-primary-button>
                            {{ __('Bagikan Postingan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            @forelse ($posts as $post)
                <div class="bg-white p-5 rounded-lg shadow-sm mb-5 border border-gray-200">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}" 
                                 class="w-11 h-11 rounded-full object-cover mr-3 border">
                            <div>
                                <h4 class="font-bold text-gray-900 leading-none">{{ $post->user->name }}</h4>
                                <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex space-x-3 items-center text-sm">
                            @if(Auth::user()->id === $post->user_id)
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                            @endif

                            @if(Auth::user()->id === $post->user_id || Auth::user()->role === 'admin')
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 font-medium">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <p class="text-gray-800 leading-relaxed mb-4">{{ $post->body }}</p>

                    <div class="flex items-center border-t border-b py-2 mb-4">
                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button class="{{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }} flex items-center transition">
                                <svg class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span class="font-semibold">{{ $post->likes->count() }} Like</span>
                            </button>
                        </form>
                    </div>

                    <div class="space-y-3">
                        @foreach($post->comments as $comment)
                            <div class="flex items-start justify-between group">
                                <div class="flex items-start space-x-2">
                                    <div class="bg-gray-100 p-2 rounded-2xl px-4 text-sm max-w-full">
                                        <span class="font-bold block text-gray-900">{{ $comment->user->name }}</span>
                                        {{ $comment->content }}
                                    </div>
                                </div>

                                {{-- FITUR HAPUS KOMENTAR: Admin atau Pemilik Komentar --}}
                                @if(Auth::id() === $comment->user_id || Auth::user()->role === 'admin')
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition px-2">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                        
                        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3 flex items-center space-x-2">
                            @csrf
                            <input type="text" name="content" placeholder="Tulis komentar..." 
                                class="flex-1 border-gray-200 rounded-full px-4 text-sm focus:ring-blue-200 focus:border-blue-400" required>
                            <button type="submit" class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-sm font-bold hover:bg-blue-100 transition">
                                Kirim
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center p-10 bg-white rounded-lg border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada postingan. Jadilah yang pertama!</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>