@extends('emails.layout')

@section('content')
    <p>
        @lang('emails.dear_firstname_lastname', ['firstname' =>$user->Keresztnev, 'lastname' => $user->Vezeteknev ])
    </p>
    <p>
        @lang('emails.forgot_password_link'):<br/>
        <a href="{{ LUrl::route('password.reset', ['token' => $token], true) }}">{{ LUrl::route('password.reset', ['token' => $token], true) }}</a>
    </p>

    @include('emails.includes.footer')
@endsection
