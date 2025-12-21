<div class="w-full max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow-lg">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800">Notifikasi</h2>
        <p class="text-sm text-gray-500 mt-1">Ini adalah pemberitahuan terbaru Anda.</p>
    </div>
    <ul class="divide-y divide-gray-200">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $user_avatar = $data['user_avatar'] ?? 'https://ui-avatars.com/api/?name=?&color=7F9CF5&background=EBF4FF';
                $user_name = $data['user_name'] ?? 'Seseorang';
                $message = $data['message'] ?? 'Notifikasi tidak valid.';
                $url = $data['url'] ?? '#';
            @endphp
            <li wire:key="{{ $notification->id }}" class="transition duration-150 ease-in-out hover:bg-gray-50">
                <a href="{{ $url }}" class="block p-4">
                    <div class="flex items-start">
                        <img class="h-12 w-12 rounded-full object-cover mr-4" src="{{ $user_avatar }}" alt="{{ $user_name }}">
                        <div class="flex-grow">
                            <p class="text-md font-medium text-gray-900">
                                {{ $message }}
                            </p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                @if(is_null($notification->read_at))
                                    <span class="px-3 py-1 bg-sky-100 text-sky-600 rounded-full text-xs font-semibold">Baru</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="p-8 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Notifikasi</h3>
                <p class="mt-1 text-sm text-gray-500">Saat ada pemberitahuan baru, akan muncul di sini.</p>
            </li>
        @endforelse
    </ul>
    @if($notifications->count() > 0)
        <div class="p-4 bg-gray-50 border-t border-gray-200 text-center">
            <button wire:click="markAllAsRead" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                Tandai semua sudah dibaca
            </button>
        </div>
    @endif
</div>