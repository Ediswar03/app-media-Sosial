<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
   public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (Name & Email).
     * Method ini WAJIB ADA untuk route PATCH /profile
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Isi data user dengan data yang sudah divalidasi
        $request->user()->fill($request->validated());

        // Jika email berubah, reset verifikasi email
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Simpan perubahan
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's avatar or cover image.
     */ 
    public function updateImages(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'], // Max 1MB
            'cover'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Max 2MB
        ]);

        $message = 'No changes made.';

        // LOGIC UPLOAD AVATAR
        if ($request->hasFile('avatar')) {
            // 1. Simpan file baru dulu
            $path = $request->file('avatar')->store('avatars', 'public');

            // 2. Jika berhasil simpan, baru hapus yang lama (agar aman)
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            // 3. Update database
            $user->update(['avatar_path' => $path]);
            $message = 'Avatar updated successfully.';
        }

        // LOGIC UPLOAD COVER
        if ($request->hasFile('cover')) {
            // 1. Simpan file baru
            $path = $request->file('cover')->store('covers', 'public');

            // 2. Hapus file lama
            if ($user->cover_path && Storage::disk('public')->exists($user->cover_path)) {
                Storage::disk('public')->delete($user->cover_path);
            }

            // 3. Update database
            $user->update(['cover_path' => $path]);
            $message = 'Cover image updated successfully.';
        }

        return Redirect::back()->with('status', $message); // Gunakan 'status' agar konsisten dengan blade bawaan
    }

    /**
     * Delete the user's account.
     */
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