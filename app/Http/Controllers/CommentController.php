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
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // 2. Simpan komentar menggunakan relasi
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit komentar
     */
    public function edit(Comment $comment): View
    {
        // Keamanan: Hanya pemilik komentar atau Admin yang bisa edit
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }

        return view('comments.edit', compact('comment'));
    }

    /**
     * Menyimpan perubahan komentar
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        // Keamanan: Hanya pemilik komentar atau Admin yang bisa update
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui!');
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