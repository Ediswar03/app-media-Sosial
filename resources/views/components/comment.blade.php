<div class="flex items-start space-x-2">
    <img
        src="{{ $comment->user->avatar
            ? asset('storage/' . $comment->user->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
        class="w-8 h-8 rounded-full object-cover border"
    >
    <div>
        <div class="flex items-start justify-between group">
            <div class="bg-gray-100 p-2 rounded-2xl px-4 text-sm">
                <span class="font-bold block">
                    {{ $comment->user->name }}
                </span>
                {{ $comment->content }}
            </div>

            <div class="ml-2 flex items-center space-x-2">
                @if (Auth::id() === $comment->user_id)
                    <a href="{{ route('comments.edit', $comment->id) }}" class="text-xs text-blue-400 hover:text-blue-600 font-medium opacity-0 group-hover:opacity-100">
                        Edit
                    </a>
                @endif
                @if (Auth::id() === $comment->user_id || Auth::user()->role === 'admin')
                    <form
                        action="{{ route('comments.destroy', $comment->id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus komentar ini?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            class="text-xs text-red-400 hover:text-red-600 font-medium opacity-0 group-hover:opacity-100"
                        >
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-2 text-xs text-gray-500 mt-1">
            <span>{{ $comment->created_at->diffForHumans() }}</span>
            <button class="font-bold hover:underline" onclick="toggleReplyForm('{{ $comment->id }}')">Reply</button>
        </div>

        <div id="reply-form-{{ $comment->id }}" class="hidden mt-2 ml-4">
            <form
                action="{{ route('comments.store', $post->id) }}"
                method="POST"
                class="flex items-center space-x-2"
            >
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <input
                    type="text"
                    name="content"
                    required
                    placeholder="Balas komentar..."
                    class="flex-1 rounded-full border-gray-200 px-4 text-sm"
                >
                <button
                    class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full font-bold"
                >
                    Kirim
                </button>
            </form>
        </div>

        @if ($comment->replies->count() > 0)
            <div class="ml-6 mt-3 space-y-3">
                @foreach ($comment->replies as $reply)
                    @include('components.comment', ['comment' => $reply, 'post' => $post])
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form) {
            form.classList.toggle('hidden');
        }
    }
</script>
