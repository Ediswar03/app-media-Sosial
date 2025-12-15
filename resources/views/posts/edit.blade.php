<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Postingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PATCH') {{-- Penting: Laravel menggunakan PATCH/PUT untuk update --}}

                        <div class="mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Konten Postingan</label>
                            <textarea 
                                name="body" 
                                id="body" 
                                rows="5" 
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm transition"
                                required>{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-6">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>