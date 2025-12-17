<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fusonic\OpenGraph\Consumer;

class UrlPreviewController extends Controller
{
    public function preview(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            $consumer = new Consumer();
            $urlData = $consumer->loadUrl($request->url);

            return response()->json([
                'title' => $urlData->title,
                'description' => $urlData->description,
                'image' => $urlData->images[0]->url ?? null,
                'url' => $urlData->url,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch URL preview.'], 400);
        }
    }
}
