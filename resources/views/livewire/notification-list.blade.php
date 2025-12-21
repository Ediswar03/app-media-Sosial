<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Notifikasi Terbaru</h2>
    <ul class="divide-y divide-gray-200">
        @forelse($notifications as $notif)
            <li class="py-3 flex items-center justify-between">
                <div>
                    <a href="{{ $notif->url }}" class="text-base text-gray-800 hover:underline">
                        {{ $notif->message }}
                    </a>
                    <div class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</div>
                </div>
                @if(is_null($notif->read_at))
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Baru</span>
                @endif
            </li>
        @empty
            <li class="py-3 text-gray-500">Tidak ada notifikasi terbaru.</li>
        @endforelse
    </ul>
</div>
