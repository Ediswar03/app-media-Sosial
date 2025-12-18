<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UrlPreviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// Route Auth bawaan (Login, Register, dll)
require __DIR__.'/auth.php';

// Route Public Profile
Route::get('/u/{username}', [ProfileController::class, 'index'])->name('profile.index');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
// Baris 32: Grup utama (Auth & Verified) dimulai di sini
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (Menampilkan Post)
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    // --- Profile Management ---
    
    // Custom: Update Foto Profil
    Route::patch('/profile/images', [ProfileController::class, 'updateImages'])->name('profile.updateImages');
    // Tambahan POST agar aman jika form menggunakan method POST
    Route::post('/profile/images', [ProfileController::class, 'updateImages'])->name('profile.updateImages.post');

    Route::prefix('profile')->name('profile.')->group(function () {
        // Route bawaan Breeze
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // --- Posts ---
    Route::resource('posts', PostController::class)->except(['index']);
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

    // --- Comments ---
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::patch('/{comment}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });

    // --- Utilities ---
    Route::post('/url-preview', [UrlPreviewController::class, 'preview'])->name('url.preview');

}); // Tutup kurung untuk Route::middleware(['auth', 'verified'])