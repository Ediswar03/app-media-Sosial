<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileServeController extends Controller
{
    /**
     * Serve user avatars from storage.
     *
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function userAvatar(string $path)
    {
        // Construct the full path to the file in the 'public' disk
        $fullPath = 'public/' . $path;

        if (!Storage::exists($fullPath)) {
            // If the file does not exist, redirect to a default avatar or return 404
            // For now, let's redirect to ui-avatars.com as a fallback
            return redirect('https://ui-avatars.com/api/?name=Default&color=7F9CF5&background=EBF4FF');
        }

        // Get the file's MIME type
        $mimeType = Storage::mimeType($fullPath);

        // Return the file as a streamed response
        return Storage::response($fullPath, null, ['Content-Type' => $mimeType]);
    }

    /**
     * Serve user cover images from storage.
     *
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function userCover(string $path)
    {
        // Construct the full path to the file in the 'public' disk
        $fullPath = 'public/' . $path;

        if (!Storage::exists($fullPath)) {
            // If the file does not exist, redirect to a default cover image
            return redirect(asset('images/default-cover.jpg'));
        }

        // Get the file's MIME type
        $mimeType = Storage::mimeType($fullPath);

        // Return the file as a streamed response
        return Storage::response($fullPath, null, ['Content-Type' => $mimeType]);
    }

    /**
     * Serve general attachment files from storage.
     *
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function serveAttachment(string $path)
    {
        $fullPath = 'public/' . $path;

        if (!Storage::exists($fullPath)) {
            // For attachments, we might want to return a 404 or a default placeholder
            abort(404, 'Attachment not found.');
        }

        $mimeType = Storage::mimeType($fullPath);

        return Storage::response($fullPath, null, ['Content-Type' => $mimeType]);
    }    /**
     * Serve the application logo from the public directory.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function serveAppLogo()
    {
        $path = public_path('Images/3.png');

        if (!file_exists($path)) {
            abort(404, 'Application logo not found.');
        }

        return response()->file($path);
    }
}
