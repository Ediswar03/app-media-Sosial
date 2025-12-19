<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryComment; // Pastikan model ini ada (jika belum, lihat langkah 3)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    /**
     * Menyimpan Story Baru
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB
            'caption' => 'nullable|string|max:255',
        ]);

        // 2. Upload Gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');

            // 3. Simpan ke Database
            Story::create([
                'user_id' => Auth::id(),
                'image_path' => $path,
                'caption' => $request->caption,
                'expires_at' => now()->addHours(24), // Story aktif selama 24 jam
            ]);

            return back()->with('success', 'Cerita berhasil diunggah!');
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    /**
     * Menyimpan Komentar pada Story
     */
    public function comment(Request $request, Story $story)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Pastikan Anda sudah membuat Model StoryComment
        // Jika belum, pakai: php artisan make:model StoryComment
        StoryComment::create([
            'story_id' => $story->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar terkirim!');
    }
}