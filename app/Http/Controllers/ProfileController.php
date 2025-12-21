<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil publik user lain (atau diri sendiri).
     * Route: /u/{username}
     */
    public function index($username): View
    {
        // Logika: Coba cari berdasarkan username kolom
        $user = User::where('username', $username)->first();

        // Jika gagal dan inputnya angka, coba cari by ID
        if (!$user && is_numeric($username)) {
            $user = User::find($username);
        }

        // Jika user tidak ditemukan, tampilkan 404
        if (!$user) {
            abort(404);
        }

        return view('profile.index', compact('user'));
    }

    /**
     * Menampilkan halaman settings (Password & Account Deletion).
     */
    public function settings(Request $request): View
    {
        return view('profile.settings', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Menampilkan formulir edit profil (Informasi Pribadi).
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update informasi profil TEXT (Nama & Email).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * [BARU] Menampilkan Form Upload Gambar (GET).
     * Opsional: Jika Anda ingin halaman khusus update gambar terpisah.
     */
    public function editImage(Request $request): View
    {
        return view('profile.update-images', [
            'user' => $request->user(),
        ]);
    }
public function updateImages(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $request->validate([
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096', // Cover biasanya file lebih besar
    ]);

    // 1. Handle Upload Avatar
    $avatarChanged = false;
    $coverChanged = false;

    if ($request->hasFile('avatar')) {
        // Hapus avatar lama jika bukan default
        if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
            Storage::delete('public/' . $user->avatar);
        }
        
        // Simpan yang baru
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $avatarChanged = true;
    }

    // 2. Handle Upload Cover Image
    if ($request->hasFile('cover_image')) {
        // Hapus cover lama
        if ($user->cover_image && Storage::exists('public/' . $user->cover_image)) {
            Storage::delete('public/' . $user->cover_image);
        }

        // Simpan yang baru
        $path = $request->file('cover_image')->store('covers', 'public');
        $user->cover_image = $path;
        $coverChanged = true;
    }

    $user->save();

    // 3. Notify followers about profile/cover updates
    if ($avatarChanged || $coverChanged) {
        $followers = $user->followers()->get();

        foreach ($followers as $follower) {
            if ($avatarChanged) {
                $follower->notify(new \App\Notifications\ProfilePhotoUpdatedNotification($user));
            }

            if ($coverChanged) {
                $follower->notify(new \App\Notifications\CoverPhotoUpdatedNotification($user));
            }
        }
    }

    return back()->with('success', 'Gambar profil berhasil diperbarui!');
}
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}