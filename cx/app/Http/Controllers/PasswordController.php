<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Mail\PasswordReset;
use App\Mail\PasswordResetConfirm;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('pages.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('pages/account.email_does_not_exist')]);
        }

        $password_reset = DB::table('password_resets')->where('email', $request->email)->first();

        do {
            $token = Str::random(32);
        } while (User::where('remember_token', $token)->count() > 0);

        if (! $password_reset) {
            // create the password_reset
            DB::table('password_resets')->insert(
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );
        } else {
            // update the password_reset
            DB::table('password_resets')
                ->where('email', $request->email)
                ->update(
                    [
                        'token' => $token,
                        'created_at' => Carbon::now(),
                    ]
                );
        }

        $user->remember_token = $token;
        $user->save();

        Mail::to($user)->send(new PasswordReset($user, $token));

        flash()->success(trans('pages/account.password_email_success_message'));

        return redirect()->route(LUrl::name('password.request'));
    }

    public function reset(Request $request): RedirectResponse
    {
        $user = User::where('remember_token', $request->token)->first();

        if (! $user) {
            flash()->error(trans('pages/account.password_email_hash_error'));

            return redirect()->route(LUrl::name('password.request'));
        }

        $user->remember_token = null;
        $user->save();

        Auth::login($user);

        flash()->success(trans('pages/account.change_your_password'));

        return redirect()->route(LUrl::name('password.update'));
    }

    public function showUpdateForm()
    {
        return view(
            'pages.auth.passwords.update',
            [
                'user' => app('User')->getUser(),
            ]
        );
    }

    public function update(Request $request, UserRepository $userRepository): RedirectResponse
    {
        $request->validate(
            [
                'password' => 'required|min:6|confirmed',
                'current_password' => ['required', function ($attribute, $value, $fail) {
                    if (! \Hash::check($value, Auth::user()->password)) {
                        return $fail(trans('validation.incorrect_current_password'));
                    }
                }],
            ]
        );

        $user = app('User')->getUser();
        $user->password = bcrypt($request->password);
        $user->save();

        $userRepository->deleteInvitation($user);

        DB::table('password_resets')->where('email', $request->email)->delete();

        Mail::send(new PasswordResetConfirm($user));

        flash()->success(trans('pages/account.the_password_changed'));

        return redirect()->route(LUrl::name('account.index'));
    }
}
