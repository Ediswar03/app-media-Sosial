<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Attachment;
use App\Models\Story; // Pastikan Model Story diimport
use App\Notifications\PostCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Menampilkan daftar postingan dan cerita (Stories)
     */
    public function index()
    {
        // 1. Ambil Postingan
        $posts = Post::with(['user', 'comments.user', 'comments.replies.user', 'likes', 'attachments'])
                    ->latest()
                    ->paginate(10);
        
        // 2. Ambil Stories (Untuk slider di dashboard)
        // Hanya ambil story yang belum kadaluwarsa (expires_at > sekarang)
        $stories = Story::where('expires_at', '>', now())
                    ->with('user')
                    ->latest()
                    ->get();

        // Kirim kedua variabel ke view dashboard
        return view('dashboard', compact('posts', 'stories'));
    }

    /**
     * Menyimpan postingan baru
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'body' => 'nullable|string', 
            'attachments.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:51200', // Max 50MB
        ]);

        // 2. Cek agar user tidak mengirim post kosong (tanpa teks DAN tanpa file)
        if (!$request->body && !$request->hasFile('attachments')) {
            return back()->withErrors(['body' => 'Konten postingan tidak boleh kosong (isi teks atau upload file).']);
        }

        // 3. Buat Postingan Utama
        // Menggunakan operator ?? '' agar jika body null, tersimpan sebagai string kosong
        $post = Post::create([
            'user_id' => auth()->id(),
            'body' => $request->body ?? '', 
        ]);

        // 4. Proses Upload File (Jika ada)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Simpan ke storage/app/public/posts
                $path = $file->store('posts', 'public');

                // Simpan ke database attachments
                Attachment::create([
                    'post_id' => $post->id,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        // 5. Kirim notifikasi ke followers
        $user = auth()->user();
        $followers = $user->followers()->get();
        foreach ($followers as $follower) {
            $follower->notify(new PostCreatedNotification($post, $user));
        }

        return redirect()->back()->with('success', 'Postingan berhasil dibuat!');
    }

    /**
     * Menghapus postingan beserta lampirannya
     */
    public function destroy(Post $post)
    {
        // 1. Otorisasi: Hanya pemilik atau admin yang boleh hapus
        if (Auth::user()->id !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }
        
        // 2. Hapus file fisik dari storage
        foreach ($post->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->path)) {
                Storage::disk('public')->delete($attachment->path);
            }
        }

        // 3. Hapus record dari database (Cascade akan menghapus komen/like/attachment terkait)
        $post->delete();

        return back()->with('success', 'Postingan berhasil dihapus.');
    }

    /**
     * Fitur Like/Unlike (AJAX)
     */
    public function like(Post $post)
    {
        $user = auth()->user();

        if ($post->isLikedBy($user)) {
            // Jika sudah like -> Unlike
            $post->likes()->where('user_id', $user->id)->delete();
            $isLiked = false;
        } else {
            // Jika belum like -> Like
            $post->likes()->create(['user_id' => $user->id]);
            $isLiked = true;

            // Kirim notifikasi ke pemilik post (jika bukan diri sendiri)
            if ($post->user_id !== $user->id) {
                $post->user->notify(new \App\Notifications\PostLikedNotification($post, $user));
            }
        }

        return response()->json([
            'status' => 'success',
            'is_liked' => $isLiked,
            'likes_count' => $post->likes()->count()
        ]);
    }

    /**
     * Tampilan Edit Postingan
     */
    public function edit(Post $post)
    {
        // Otorisasi
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit postingan ini.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Proses Update Postingan
     */
    public function update(Request $request, Post $post)
    {
        // Otorisasi
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        // Validasi
        $request->validate([
            'body' => 'nullable|string|max:2000',
            'attachments.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:51200',
        ]);

        // Update Text (Handle null menjadi string kosong)
        $post->update([
            'body' => $request->body ?? ''
        ]);

        // Update Attachments (Menambah file baru)
        // Catatan: Jika ingin menghapus file lama, butuh logika tambahan di view/controller terpisah
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('posts', 'public');
                Attachment::create([
                    'post_id' => $post->id,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Postingan berhasil diperbarui!');
    }
}