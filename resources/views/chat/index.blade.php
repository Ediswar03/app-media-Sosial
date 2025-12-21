<x-app-layout>
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
        <!-- Sidebar -->
        <div class="w-1/4 flex-shrink-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold">Pesan</h1>
            </div>
            <!-- User List -->
            <div class="flex-1 overflow-y-auto">
                @forelse($users as $user)
                    <a href="{{ route('chat.show', $user) }}" class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full mr-3">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium truncate">{{ $user->name }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pengguna lain</p>
                @endforelse
            </div>
        </div>

        <!-- Main Chat Area (Placeholder) -->
        <div class="w-3/4 flex flex-col items-center justify-center text-center">
            <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <h3 class="text-xl font-medium mb-2">Selamat Datang di Obrolan</h3>
            <p class="text-gray-500">Pilih kontak di sebelah kiri untuk memulai percakapan.</p>
        </div>
    </div>
</x-app-layout>
