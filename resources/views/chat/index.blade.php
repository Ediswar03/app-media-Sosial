<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-white">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pesan</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Kirim pesan ke teman-teman Anda</p>
                </div>

                <div class="flex">
                    <!-- User List -->
                    <div class="w-1/3 border-r border-gray-200 dark:border-gray-700">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kontak</h2>
                            <div class="space-y-2">
                                @forelse($users as $user)
                                    <a href="{{ route('chat.show', $user) }}"
                                       class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ request()->route('user') == $user->id ? 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500' : '' }}">
                                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pengguna lain</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="w-2/3 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Pilih kontak untuk memulai chat</h3>
                            <p>Klik pada nama pengguna di sebelah kiri untuk memulai percakapan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>