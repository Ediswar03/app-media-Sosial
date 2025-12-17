<?php

namespace App\Http\Controllers;

use App\Models\Post; // Penting: Tambahkan ini
use App\Models\Like; // Penting: Jika menggunakan model Like terpisah
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Menampilkan semua postingan di Dashboard
     */
    public function index()
    {
        // Mengambil post dengan relasi (Eager Loading) untuk mencegah N+1 Query
        $posts = Post::with(['user', 'comments.user', 'comments.replies.user', 'likes', 'attachments'])->latest()->get();
        
        return view('dashboard', compact('posts'));
    }

    /**
     * Menyimpan postingan baru
     */
    public function store(Request $request) 
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:2048', // 2MB per file
        ]);
        
        $post = $request->user()->posts()->create([
            'body' => $request->body,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('posts', 'public');
                $post->attachments()->create([
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return back()->with('success', 'Postingan berhasil dibagikan!');
    }

    /**
     * Menghapus postingan (Fitur Moderasi Admin + Pemilik)
     */
    public function destroy(Post $post) 
    {
        // Cek apakah yang menghapus adalah pemiliknya ATAU admin
        if (Auth::user()->id !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }
        
        $post->delete();
        return back()->with('success', 'Postingan berhasil dihapus.');
    }

    /**
     * Fitur Like/Unlike (Toggle)
     */
    public function like(Post $post)
    {
        $user = Auth::user();

        // Cek apakah user sudah memberikan like
        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Jika sudah ada, hapus like (Unlike)
            $existingLike->delete();
        } else {
            // Jika belum ada, tambah like
            $post->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return back();
    }
    /**
 * Menampilkan halaman edit postingan
 */
public function edit(Post $post)
{
    // Keamanan: Hanya pemilik yang bisa edit
    if (auth()->id() !== $post->user_id) {
        abort(403, 'Anda tidak memiliki izin untuk mengedit postingan ini.');
    }

    return view('posts.edit', compact('post'));
}

/**
 * Menyimpan perubahan postingan
 */
public function update(Request $request, Post $post)
{
    // Keamanan: Pastikan hanya pemilik yang bisa update
    if (auth()->id() !== $post->user_id) {
        abort(403);
    }

    $request->validate([
        'body' => 'required|string|max:1000'
    ]);

    $post->update([
        'body' => $request->body
    ]);

    return redirect()->route('dashboard')->with('success', 'Postingan berhasil diperbarui!');
}
}