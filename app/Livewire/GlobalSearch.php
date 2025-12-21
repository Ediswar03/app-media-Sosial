<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Post;

class GlobalSearch extends Component
{
    public $query = ''; // Menyimpan apa yang diketik user
    public $results = []; // Menyimpan hasil pencarian

    // Method untuk melakukan pencarian saat tombol diklik
    public function search()
    {
        // Validasi: tidak lakukan pencarian jika query kosong
        if (empty(trim($this->query))) {
            $this->results = [];
            return;
        }

        // Cari User
        $users = User::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('username', 'like', '%' . $this->query . '%')
            ->take(3) // Ambil 3 user saja untuk preview
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'user',
                    'id' => $user->id,
                    'title' => $user->name,
                    'subtitle' => '@' . $user->username,
                    'image' => $user->profile_photo_url, // Sesuaikan dengan accessor foto Anda
                    'url' => route('profile.show', $user->id) // Sesuaikan route profile
                ];
            });

        // Cari Postingan
        $posts = Post::where('content', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(function($post) {
                return [
                    'type' => 'post',
                    'id' => $post->id,
                    'title' => str($post->content)->limit(30),
                    'subtitle' => 'Post oleh ' . $post->user->name,
                    'image' => null, // Post mungkin tidak punya icon khusus
                    'url' => route('posts.show', $post->id) // Sesuaikan route post
                ];
            });

        // Gabungkan hasil
        $this->results = $users->concat($posts);
    }

    // Method ini otomatis jalan setiap $query berubah - sekarang tidak digunakan untuk pencarian
    public function updatedQuery()
    {
        // Reset hasil jika input kosong
        if (empty(trim($this->query))) {
            $this->results = [];
        }
        // Pencarian sekarang hanya dilakukan saat tombol diklik
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}