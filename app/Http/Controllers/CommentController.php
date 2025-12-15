<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Menyimpan komentar baru ke database
     */
    public function store(Request $request, Post $post)
    {
        // 1. Validasi input
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // 2. Simpan komentar menggunakan relasi
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Menghapus komentar (Fitur Moderasi)
     */
    public function destroy(Comment $comment)
    {
        // Hanya pemilik komentar atau Admin yang bisa menghapus
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $comment->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}