<?php

namespace App\Http\Controllers;

use App\Libs\Fct;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('pages.account', ['user' => app('User')]);
    }

    public function installerPriceSave(Request $request): array
    {
        if (! Fct::isReseller()) {
            abort(403);
        }

        $installerPrice = ($request->value == 'true');

        $user = app('User')->getUser();
        $user->TelepitoiAr = $installerPrice;
        $user->save();

        return [
            'value' => $installerPrice,
        ];
    }
}
