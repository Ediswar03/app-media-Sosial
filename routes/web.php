<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UrlPreviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChatController;

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

// Route for serving user avatars
Route::get('/user-avatar/{path}', [FileServeController::class, 'userAvatar'])
    ->where('path', '.*')
    ->name('user.avatar');

// Route for serving user cover images
Route::get('/user-cover/{path}', [FileServeController::class, 'userCover'])
    ->where('path', '.*')
    ->name('user.cover');

// Route for serving general attachments
Route::get('/attachment/{path}', [FileServeController::class, 'serveAttachment'])
    ->where('path', '.*')
    ->name('attachment.serve');

// Route for serving the application logo
Route::get('/app-logo', [FileServeController::class, 'serveAppLogo'])
    ->name('app.logo');

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
        
        // Settings page
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
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


    // --- Notifikasi ---
    Route::get('/notifications', function() {
        return view('notifications');
    })->name('notifications');

    // --- Chat ---
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread-count');
    Route::delete('/messages/{message}', [ChatController::class, 'destroyMessage'])->name('messages.destroy');
    Route::patch('/messages/{message}', [ChatController::class, 'updateMessage'])->name('messages.update');
    Route::post('/messages/{message}/react', [ChatController::class, 'react'])->name('messages.react');

}); // Tutup kurung untuk Route::middleware(['auth', 'verified'])
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])
    ->name('users.follow')
    ->middleware('auth');
   Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::post('/stories/{story}/comments', [StoryController::class, 'comment'])->name('stories.comment');
});