<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil kata kunci
        $query = $request->input('q');

        // Jika kosong, kembalikan array kosong
        if (!$query) {
            return view('search.index', [
                'users' => [],
                'posts' => [],
                'query' => ''
            ]);
        }

        // 2. Cari User (Akun yang identik namanya atau usernamenya)
        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('username', 'LIKE', "%{$query}%")
                    ->limit(10) // Tampilkan maksimal 10 akun
                    ->get();

        // 3. Cari Postingan (Sesuai teks postingan)
        // Menggunakan with('user') agar Avatar & Nama di postingan muncul
        $posts = Post::with('user')
                     ->where('body', 'LIKE', "%{$query}%") 
                     ->orderBy('created_at', 'desc') // Yang terbaru di atas (seperti dashboard)
                     ->get();

        // 4. Return ke View
        return view('search.index', compact('users', 'posts', 'query'));
    }
}