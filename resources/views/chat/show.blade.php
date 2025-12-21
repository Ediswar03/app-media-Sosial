<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="flex h-[calc(100vh-10rem)] bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            <!-- User List -->
            <div class="w-1/3 flex-shrink-0 bg-gray-50 dark:bg-gray-800/50 border-r border-gray-200 dark:border-gray-700 flex flex-col">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-xl font-bold">Pesan</h1>
                </div>
                <div class="flex-1 overflow-y-auto">
                    @php
                        $otherUsers = \App\Models\User::where('id', '!=', auth()->id())->get();
                    @endphp
                    @forelse($otherUsers as $contact)
                        <a href="{{ route('chat.show', $contact) }}" class="flex items-center p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ $contact->id == $user->id ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <img src="{{ $contact->avatar_url }}" class="w-10 h-10 rounded-full mr-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium truncate">{{ $contact->name }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pengguna lain</p>
                    @endforelse
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="w-2/3 flex flex-col h-full">
                <div class="p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full mr-3">
                        <h1 class="text-lg font-bold">{{ $user->name }}</h1>
                    </div>
                </div>

                <div id="messages-container" class="flex-1 p-6 overflow-y-auto" style="background-image: url('https://i.pinimg.com/736x/8c/98/99/8c98994518b575bfd8c949e91d20548b.jpg'); background-size: cover; background-position: center;">
                    @forelse($messages as $message)
                    <div class="flex mb-4 {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}" id="message-{{ $message->id }}">
                        <div class="group relative max-w-xl">
                            <div x-data="{ open: false, editing: false }">
                                <div x-show="!editing">
                                    <div class="px-4 py-2 rounded-2xl {{ $message->sender_id == auth()->id() ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md' : 'bg-white dark:bg-gray-800 shadow-md' }}" style="position: relative;">
                                        <p class="text-sm">{{ $message->message }}</p>
                                        <div class="text-xs mt-1 text-right {{ $message->sender_id == auth()->id() ? 'text-blue-100' : 'text-gray-400' }}">
                                            {{ $message->created_at->format('H:i') }}
                                            @if($message->edited_at)
                                                <span class="italic">(edited)</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="absolute top-1/2 -translate-y-1/2 {{ $message->sender_id == auth()->id() ? 'left-[-4rem]' : 'right-[-4rem]' }} hidden group-hover:flex items-center space-x-1">
                                        <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute bottom-full mb-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg py-1 w-28">
                                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Balas</a>
                                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Teruskan</a>
                                            @if($message->sender_id == auth()->id())
                                                <button @click="editing = true; open = false" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Edit</button>
                                                <button onclick="deleteMessage({{ $message->id }})" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Hapus</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div x-show="editing" class="w-full">
                                    <input type="text" value="{{ $message->message }}" id="edit-input-{{ $message->id }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                    <div class="mt-2 flex justify-end space-x-2">
                                        <button @click="editing = false" class="text-sm text-gray-500">Cancel</button>
                                        <button onclick="saveMessage({{ $message->id }})" class="text-sm text-blue-500 font-semibold">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            <p>Belum ada pesan. Mulai percakapan!</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    <form id="message-form" class="flex items-center space-x-3">
                        @csrf
                        <div class="flex-1 relative">
                            <input type="text" id="message-input" name="message"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-full py-3 pl-12 pr-20 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700"
                                   placeholder="Ketik pesan..." required>
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center">
                                <button type="button" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </button>
                            </div>
                            <div class="absolute right-12 top-1/2 -translate-y-1/2 flex items-center">
                                <button type="button" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
    const messagesContainer = document.getElementById('messages-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const userId = {{ auth()->id() }};
    const receiverId = {{ $user->id }};

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    window.onload = scrollToBottom;

    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value;
        if (!message) return;

        fetch('{{ route('chat.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: message,
                receiver_id: receiverId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const message = data.message;
                const messageElement = `
                    <div class="flex mb-4 ${message.sender_id == userId ? 'justify-end' : 'justify-start'}" id="message-${message.id}">
                        <div class="group relative max-w-lg">
                            <div class="px-4 py-2 rounded-lg ${message.sender_id == userId ? 'bg-blue-500 text-white' : 'bg-white dark:bg-gray-700'}">
                                <p>${message.message}</p>
                                <div class="text-xs mt-1 text-right ${message.sender_id == userId ? 'text-blue-100' : 'text-gray-400'}">
                                    ${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                messagesContainer.insertAdjacentHTML('beforeend', messageElement);
                messageInput.value = '';
                scrollToBottom();
            }
        });
    });

        function deleteMessage(messageId) {
            if (!confirm('Are you sure you want to delete this message?')) {
                return;
            }

            fetch(`/messages/${messageId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove message from UI
                    document.getElementById(`message-${messageId}`).remove();
                } else {
                    alert('Error deleting message');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function saveMessage(messageId) {
            const newContent = document.getElementById(`edit-input-${messageId}`).value;

            fetch(`/messages/${messageId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: newContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update message in UI
                    const messageElement = document.getElementById(`message-${messageId}`);
                    messageElement.querySelector('p').innerText = data.message.message;
                    // You might want to find a way to get the component's scope to set editing = false
                    // For now, we just reload the page to see the change
                    window.location.reload();
                } else {
                    alert('Error updating message');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>
