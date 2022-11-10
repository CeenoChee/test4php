<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function masquerade()
    {
        return view('pages.dev.masquerade');
    }

    public function masqueradeSet(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            flash()->error('A felhasználó nem létezik.');

            return redirect()->back();
        }

        Auth::login($user);

        return redirect()->route('hu.account.index');
    }
}
