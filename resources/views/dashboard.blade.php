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
        
        {{-- Editor Teks --}}
        <trix-editor input="body" class="w-full border-gray-200 rounded-md text-lg min-h-[100px] focus:ring-blue-200 focus:border-blue-400" placeholder="Apa yang Anda pikirkan, {{ Auth::user()->name }}?"></trix-editor>

        {{-- Area Upload & Preview --}}
        <div class="mt-4">
            <x-input-label for="attachments" :value="__('Media / Gambar')" class="mb-2" />
            
            {{-- Input File yang lebih cantik --}}
            <input type="file" id="attachments" name="attachments[]" multiple accept="image/*"
                class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100
                cursor-pointer file:cursor-pointer"
            >
            
            {{-- CONTAINER PREVIEW (Menyesuaikan Posisi Form) --}}
            {{-- Menggunakan Grid agar gambar berjejer rapi --}}
            <div id="image-preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden transition-all duration-300">
                </div>
        </div>

        <div class="flex justify-end mt-4 pt-3 border-t border-gray-100">
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

                    {{-- ATTACHMENTS (TAMPILAN DI FEED) --}}
                    @if ($post->attachments->count() > 0)
                        <div class="mt-4 grid gap-2 {{ $post->attachments->count() > 1 ? 'grid-cols-2' : 'grid-cols-1' }}">
                            @foreach ($post->attachments as $attachment)
                                @if (\Illuminate\Support\Str::startsWith($attachment->mime_type, 'image/'))
                                    <img src="{{ asset('storage/' . $attachment->path) }}" 
                                         alt="Attachment" 
                                         class="w-full h-auto rounded-lg object-cover border border-gray-100 shadow-sm">
                                @else
                                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="block p-3 bg-gray-50 rounded border text-blue-500 hover:underline">
                                        📎 {{ basename($attachment->path) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    {{-- LIKE BUTTON (AJAX VERSION) --}}
<div class="flex items-center border-t border-b py-2 mb-4 mt-4">
    <button 
        onclick="toggleLike(this, {{ $post->id }})"
        data-url="{{ route('posts.like', $post) }}"
        class="flex items-center transition duration-150 group {{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}"
        id="like-btn-{{ $post->id }}"
    >
        {{-- Icon Heart --}}
        <svg id="like-icon-{{ $post->id }}" class="w-6 h-6 mr-1 transform transition-transform duration-200 group-active:scale-125" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09 C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5 c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        
        {{-- Text Count --}}
        <span class="font-semibold" id="like-count-{{ $post->id }}">
            {{ $post->likes->count() }} Like
        </span>
    </button>
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
                                class="flex-1 rounded-full border-gray-200 px-4 text-sm focus:ring-blue-200 focus:border-blue-400"
                            >
                            <button
                                class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full font-bold hover:bg-blue-100 transition"
                            >
                                Kirim
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="text-center p-10 bg-white rounded-lg border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada postingan. Jadilah yang pertama!</p>
                </div>
            @endforelse

        </div>
    </div>

    @push('scripts')
    <script>
    // ... kode trix editor yang sudah ada biarkan saja ...

    // LOGIKA PREVIEW GAMBAR
    const attachmentInput = document.getElementById('attachments');
    const previewContainer = document.getElementById('image-preview-container');

    attachmentInput.addEventListener('change', function(event) {
        // 1. Reset container (hapus preview lama jika user ganti pilihan)
        previewContainer.innerHTML = '';
        
        const files = event.target.files;

        // 2. Cek apakah ada file
        if (files.length > 0) {
            // Tampilkan container grid
            previewContainer.classList.remove('hidden');

            Array.from(files).forEach(file => {
                if (file.type.match('image.*')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // 3. Buat Element HTML untuk setiap gambar
                        const imgWrapper = document.createElement('div');
                        // Class 'relative' dan 'aspect-square' membuat gambar jadi kotak sempurna
                        imgWrapper.className = 'relative aspect-square group overflow-hidden rounded-lg border border-gray-200 shadow-sm';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        // Object-cover memastikan gambar mengisi kotak tanpa gepeng
                        img.className = 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105';
                        
                        imgWrapper.appendChild(img);
                        previewContainer.appendChild(imgWrapper);
                    }

                    reader.readAsDataURL(file);
                }
            });
        } else {
            // Sembunyikan container jika tidak ada file
            previewContainer.classList.add('hidden');
        }
    });
</script>
<script>
    // ... script preview gambar (biarkan saja) ...

    // FUNGSI LIKE TANPA RELOAD
    function toggleLike(button, postId) {
        // Ambil URL dari atribut button
        const url = button.getAttribute('data-url');
        
        // Ambil elemen icon dan text count berdasarkan ID unik
        const icon = document.getElementById(`like-icon-${postId}`);
        const countSpan = document.getElementById(`like-count-${postId}`);
        const btn = document.getElementById(`like-btn-${postId}`);

        // Efek visual sementara (biar terasa cepat)
        btn.classList.add('opacity-50'); 

        axios.post(url)
            .then(response => {
                const data = response.data;

                if (data.status === 'success') {
                    // Update Text Jumlah Like
                    countSpan.innerText = data.likes_count + ' Like';

                    // Update Warna Icon (Merah vs Abu-abu)
                    if (data.is_liked) {
                        btn.classList.remove('text-gray-500');
                        btn.classList.add('text-red-500');
                    } else {
                        btn.classList.remove('text-red-500');
                        btn.classList.add('text-gray-500');
                    }
                }
            })
            .catch(error => {
                console.error('Error liking post:', error);
                alert('Gagal memproses like. Coba lagi.');
            })
            .finally(() => {
                // Kembalikan opacity
                btn.classList.remove('opacity-50');
            });
    }
</script>
    @endpush
</x-app-layout>
<div id="url-preview-container"></div>