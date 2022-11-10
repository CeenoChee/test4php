<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function getMedia(Request $request, string $filename)
    {
        if ($request->error || $request->link || $request->protected) {
            return view('pages.media', compact('filename'));
        }

        return redirect($this->createRedirectUrl($request, $filename));
    }

    public function getImage(string $size, string $filename)
    {
        return redirect(env('FILES_APP_URL') . '/media/' . $size . '/' . $filename);
    }

    private function createRedirectUrl(Request $request, string $filename): string
    {
        $httpQuery = http_build_query([
            'user_id' => Auth::id(),
            'token' => Auth::check() ? Auth::user()->token : null,
            'password' => $request->password,
        ]);

        $redirectUrl = env('FILES_APP_URL') . '/media/' . $filename;

        if ($httpQuery !== '') {
            $redirectUrl .= '?' . $httpQuery;
        }

        return $redirectUrl;
    }
}
