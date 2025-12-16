<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <img
                src="{{ file_exists(public_path('storage/logo/app-logo.png'))
                    ? asset('storage/logo/app-logo.png')
                    : asset('images/default-logo.png') }}"
                class="w-8 h-8 object-contain"
                alt="App Logo"
            >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Social Feed
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- FORM POST --}}
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border border-gray-200">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea
                        name="body"
                        rows="3"
                        required
                        placeholder="Apa yang Anda pikirkan, {{ Auth::user()->name }}?"
                        class="w-full border-gray-200 rounded-md text-lg focus:ring-blue-200 focus:border-blue-400"
                    ></textarea>

                    <div class="flex justify-end mt-3">
                        <x-primary-button>
                            Bagikan Postingan
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- LIST POST --}}
            @forelse ($posts as $post)
                <div class="bg-white p-5 rounded-lg shadow-sm mb-5 border border-gray-200">

                    {{-- HEADER POST --}}
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-3">
                            <img
                                src="{{ $post->user->avatar
                                    ? asset('storage/' . $post->user->avatar)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}"
                                class="w-11 h-11 rounded-full object-cover border"
                            >
                            <div>
                                <h4 class="font-bold text-gray-900">
                                    {{ $post->user->name }}
                                </h4>
                                <span class="text-xs text-gray-500">
                                    {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="flex space-x-3 text-sm">
                            @if (Auth::id() === $post->user_id)
                                <a href="{{ route('posts.edit', $post) }}"
                                   class="text-blue-500 hover:text-blue-700 font-medium">
                                    Edit
                                </a>
                            @endif

                            @if (Auth::id() === $post->user_id || Auth::user()->role === 'admin')
                                <form
                                    action="{{ route('posts.destroy', $post) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus postingan ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- BODY POST --}}
                    <p class="text-gray-800 leading-relaxed mb-4">
                        {{ $post->body }}
                    </p>

                    {{-- LIKE --}}
                    <div class="flex items-center border-t border-b py-2 mb-4">
                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button
                                class="{{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}
                                flex items-center"
                            >
                                <svg class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                    2 5.42 4.42 3 7.5 3c1.74 0
                                    3.41.81 4.5 2.09
                                    C13.09 3.81 14.76 3 16.5 3
                                    19.58 3 22 5.42 22 8.5
                                    c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span class="font-semibold">
                                    {{ $post->likes->count() }} Like
                                </span>
                            </button>
                        </form>
                    </div>

                    {{-- KOMENTAR --}}
                    <div class="space-y-3">
                        @foreach ($post->comments as $comment)
                            <div class="flex items-start justify-between group">
                                <div class="flex items-start space-x-2">
                                    <div class="bg-gray-100 p-2 rounded-2xl px-4 text-sm">
                                        <span class="font-bold block">
                                            {{ $comment->user->name }}
                                        </span>
                                        {{ $comment->content }}
                                    </div>
                                </div>

                                @if (Auth::id() === $comment->user_id || Auth::user()->role === 'admin')
                                    <form
                                        action="{{ route('comments.destroy', $comment->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus komentar ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-xs text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach

                        <form
                            action="{{ route('comments.store', $post->id) }}"
                            method="POST"
                            class="flex items-center space-x-2 mt-2"
                        >
                            @csrf
                            <input
                                type="text"
                                name="content"
                                required
                                placeholder="Tulis komentar..."
                                class="flex-1 rounded-full border-gray-200 px-4 text-sm"
                            >
                            <button
                                class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full font-bold"
                            >
                                Kirim
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="text-center p-10 bg-white rounded-lg border border-dashed">
                    <p class="text-gray-500">Belum ada postingan.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
