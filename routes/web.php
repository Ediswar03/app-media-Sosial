<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UrlPreviewController;
use Illuminate\Support\Facades\Route;

// 1. Halaman Utama (Guest)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Terproteksi (Harus Login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard: Sekarang diarahkan ke PostController agar bisa mengambil data $posts
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    // Profile CRUD
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post CRUD (Store, Edit, Update, Destroy)
    Route::resource('posts', PostController::class)->except(['index']);
    
    // Fitur Like
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

    // Fitur Komentar
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // URL Preview
    Route::post('/url-preview', [UrlPreviewController::class, 'preview'])->name('url.preview');
});

// 3. Rute Khusus Admin (Moderasi)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');