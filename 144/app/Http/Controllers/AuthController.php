<?php

namespace App\Http\Controllers;

use App\Classes\CompanyTaxNumber;
use App\Http\Requests\RegistrationRequest;
use App\Libs\LUrl;
use App\Libs\UserInfo;
use App\Mail\Register;
use App\Mail\RegisterConfirm;
use App\Mail\Verification;
use App\Models\Country;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.auth.register', [
            'countries' => Country::getOptions(),
        ]);
    }

    public function register(RegistrationRequest $request): RedirectResponse
    {
        do {
            $token = Str::random(60);
        } while (User::where('token', $token)->exists());

        $user = $this->createUser($request, $token);

        Mail::send(new Register($user));

        session()->put('user_id', $user->id);

        flash()->success(trans('pages/auth.confirm_your_email', ['email' => $user->email]));

        return redirect()->route(LUrl::name('register_summary'));
    }

    public function showRegistrationSummary(Request $request)
    {
        if ($request->session()->has('user_id')) {
            $user_id = $request->session()->get('user_id');
            $request->session()->forget('user_id');
            $user = User::where('id', $user_id)->firstOrFail();

            return view('pages.auth.register-summary', ['user' => $user]);
        }

        return redirect()->route(LUrl::name('login'));
    }

    public function confirm($token): RedirectResponse
    {
        $user = User::where('token', $token)->first();

        if (is_null($user)) {
            flash()->error(trans('pages/auth.not_valid_link'));

            return redirect()->route(LUrl::name('login'));
        }

        (new UserRepository())->confirm($user);

        Mail::send(new RegisterConfirm($user));

        if (empty($user->password)) {
            Auth::login($user);

            flash()->success(trans('pages/auth.register_success'));

            return redirect()->route(LUrl::name('password.update'));
        }

        flash()->success(trans('pages/auth.your_mail_is_valid'));

        return redirect()->route(LUrl::name('login'));
    }

    public function sendVerification(): RedirectResponse
    {
        $user = app('User')->getUser();

        if ($user->verified) {
            abort(404);
        }

        do {
            $token = Str::random(60);
        } while (User::where('token', $token)->exists());

        $user->token = $token;
        $user->save();

        Mail::send(new Verification($user));

        flash()->success(trans('pages/auth.send_verification_success'));

        return redirect()->route(LUrl::name('account.index'));
    }

    public function verify($token): RedirectResponse
    {
        $user = User::where('token', $token)->first();

        if (app('User')->isLoggedIn()) {
            $route = LUrl::name('account.index');
        } else {
            $route = LUrl::name('login');
        }

        if (is_null($user)) {
            flash()->error(trans('pages/auth.not_valid_link'));

            return redirect()->route($route);
        }

        // update the user
        $user->verified = true;
        $user->token = Str::random(60);
        $user->save();

        Mail::send(new RegisterConfirm($user));

        flash()->success(trans('pages/auth.your_mail_is_valid'));

        return redirect()->route($route);
    }

    public function showLoginForm()
    {
        return view('pages.auth.login', [
            'previous_url' => session('_previous.url'),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $banned = false;

        $user = User::getByEmail($request->email);

        if ($user) {
            $userInfo = new UserInfo($user);
            $banned = ($userInfo->isBanned() === true);
        }

        // attempt to login the user
        if (! $banned && $this->guard()->attempt($this->credentials($request), $request->filled('remember'))) {
            $request->session()->regenerate();

            $user->token = Str::random(60);
            $user->save();

            $customerEmployee = app('User')->getCustomerEmployee();

            if (! $customerEmployee) {
                $redirectTo = LUrl::route('account.index');
            } elseif (! is_null($request->previous_url)) {
                $redirectTo = $request->previous_url;
            } else {
                $redirectTo = LUrl::route('home');
            }

            return redirect()->to($redirectTo);
        }

        flash()->error(trans('pages/auth.incorrect_password'));

        return redirect()->back()->withInput($request->except('password'));
    }

    public function logout(): RedirectResponse
    {
        if (Auth::check()) {
            $this->guard()->logout();
        }

        $redirectUrl = session('_previous.url') ?: LUrl::name('home');

        return redirect()->to($redirectUrl);
    }

    public function getCompanyDetailsByTaxNumber(Request $request)
    {
        return (new CompanyTaxNumber($request->taxNumber))->getCompanyDetailsByTaxNumber();
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function credentials(Request $request): array
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    private function createUser(RegistrationRequest $request, string $token): User
    {
        $user = new User();
        $user->Keresztnev = $request->firstname;
        $user->Vezeteknev = $request->lastname;
        $user->Beosztas = $request->title;
        $user->Telefon = $request->telephone;
        $user->Mobil = $request->mobile;
        $user->Fax = $request->fax;
        $user->Orszag_ID = $request->country;
        $user->IrSzam = $request->zip;
        $user->Helyseg = $request->city;
        $user->UtcaHSzam = $request->address;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->Cegnev = $request->company_name;
        $user->Adoszam = $request->company_tax_number;
        $user->Cegjegyzekszam = $request->company_registration_number;
        $user->token = $token;
        $user->verified = false;
        $user->newsletter = $request->has('newsletter');
        $user->save();

        return $user;
    }
}
