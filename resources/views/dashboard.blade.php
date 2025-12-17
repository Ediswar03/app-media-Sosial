<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Social Feed
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- FORM POST --}}
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border border-gray-200">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="body" type="hidden" name="body">
                    <trix-editor input="body" class="w-full border-gray-200 rounded-md text-lg focus:ring-blue-200 focus:border-blue-400" placeholder="Apa yang Anda pikirkan, {{ Auth::user()->name }}?"></trix-editor>

                    <div class="mt-4">
                        <x-input-label for="attachments" :value="__('Attachments')" />
                        <input type="file" id="attachments" name="attachments[]" multiple class="block mt-1 w-full">
                    </div>

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
                        {!! $post->body !!}
                    </p>

                    {{-- ATTACHMENTS --}}
                    @if ($post->attachments->count() > 0)
                        <div class="mt-4">
                            @foreach ($post->attachments as $attachment)
                                @if (\Illuminate\Support\Str::startsWith($attachment->mime_type, 'image/'))
                                    <img src="{{ asset('storage/' . $attachment->path) }}" alt="Attachment" class="max-w-full h-auto rounded-lg mb-2">
                                @else
                                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="text-blue-500 hover:underline">{{ $attachment->path }}</a>
                                @endif
                            @endforeach
                        </div>
                    @endif

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
                        @foreach ($post->comments->whereNull('parent_id') as $comment)
                            @include('components.comment', ['comment' => $comment, 'post' => $post])
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

    @push('scripts')
    <script>
        document.addEventListener('trix-change', function (event) {
            const editor = event.target.editor;
            const content = editor.getDocument().toString();
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            const urls = content.match(urlRegex);

            if (urls) {
                const url = urls[0];
                axios.post('{{ route('url.preview') }}', { url: url })
                    .then(function (response) {
                        const preview = `
                            <div class="mt-4 border rounded-lg p-4">
                                <a href="${response.data.url}" target="_blank">
                                    <img src="${response.data.image}" alt="Preview" class="max-w-full h-auto rounded-lg mb-2">
                                    <h3 class="font-bold text-lg">${response.data.title}</h3>
                                    <p class="text-gray-600">${response.data.description}</p>
                                </a>
                            </div>
                        `;
                        const previewContainer = document.getElementById('url-preview-container');
                        if (previewContainer) {
                            previewContainer.innerHTML = preview;
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        });
    </script>
    @endpush
</x-app-layout>
<div id="url-preview-container"></div>
