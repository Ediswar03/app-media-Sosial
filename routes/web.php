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

// --- 1. HALAMAN PUBLIK (Bisa diakses Tamu & User Login) ---

Route::get('/', function () {
    return view('welcome');
});

// ✅ PERBAIKAN: Route Profile Publik ditaruh di sini
// URL: domain.com/u/john_doe
// Name: profile.index
Route::get('/u/{username}', [ProfileController::class, 'index'])->name('profile.index');


// --- 2. HALAMAN TERPROTEKSI (Wajib Login & Email Verified) ---

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (Feed Utama)
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    // Group: Profile Settings (Edit Akun)
    // URL dasar: /profile
    Route::prefix('profile')->name('profile.')->group(function () {
        
        // ✅ PERBAIKAN: Hapus route 'index' dari sini agar tidak bentrok
        // URL ini (/profile) khusus untuk EDIT/SETTINGS
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');          // Menjadi: route('profile.edit')
        
        Route::patch('/', [ProfileController::class, 'update'])->name('update');    // Menjadi: route('profile.update')
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy'); // Menjadi: route('profile.destroy')
        
        // Custom Update Foto
        Route::post('/update-images', [ProfileController::class, 'updateImages'])->name('updateImages');
    });

    // Group: Posts
    Route::resource('posts', PostController::class)->except(['index']);
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

    // Group: Comments
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::patch('/{comment}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });
    
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Group: Utilities
    Route::post('/url-preview', [UrlPreviewController::class, 'preview'])->name('url.preview');
});


// --- 3. HALAMAN ADMIN (Wajib Login & Role Admin) ---

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';