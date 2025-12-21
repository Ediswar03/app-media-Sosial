<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-white">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <a href="{{ route('chat.index') }}" class="mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                        </div>
                    </div>
                </div>

                <div class="flex">
                    <!-- User List Sidebar -->
                    <div class="w-1/3 border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kontak</h2>
                            <div class="space-y-2">
                                @php
                                    $otherUsers = \App\Models\User::where('id', '!=', auth()->id())->get();
                                @endphp
                                @forelse($otherUsers as $contact)
                                    <a href="{{ route('chat.show', $contact) }}"
                                       class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ $contact->id == $user->id ? 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500' : '' }}">
                                        <img src="{{ $contact->avatar_url }}" class="w-8 h-8 rounded-full mr-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-900 dark:text-white truncate">{{ $contact->name }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pengguna lain</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="w-2/3 flex flex-col h-96">
                        <!-- Messages Container -->
                        <div id="messages-container" class="flex-1 p-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                            @forelse($messages as $message)
                                <div class="mb-4 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                                    <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-600' }}">
                                        <p class="text-sm">{{ $message->message }}</p>
                                        <p class="text-xs mt-1 {{ $message->sender_id == auth()->id() ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $message->created_at->format('H:i') }}
                                            @if($message->isRead() && $message->sender_id == auth()->id())
                                                <span class="ml-1">✓✓</span>
                                            @elseif($message->sender_id == auth()->id())
                                                <span class="ml-1">✓</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                    <p>Belum ada pesan. Mulai percakapan!</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Message Input -->
                        <div class="border-t border-gray-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
                            <form id="message-form" class="flex space-x-3">
                                @csrf
                                <input type="text" id="message-input" name="message"
                                       class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                       placeholder="Ketik pesan..." required>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition">
                                    Kirim
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const messagesContainer = document.getElementById('messages-container');

            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message) return;

                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add message to UI
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'mb-4 text-right';
                        messageDiv.innerHTML = `
                            <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg bg-blue-500 text-white">
                                <p class="text-sm">${data.message.message}</p>
                                <p class="text-xs mt-1 text-blue-100">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})} ✓</p>
                            </div>
                        `;
                        messagesContainer.appendChild(messageDiv);
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        messageInput.value = '';
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            // Auto scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    </script>
</x-app-layout>