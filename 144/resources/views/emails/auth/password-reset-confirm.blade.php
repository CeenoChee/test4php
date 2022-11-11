@extends('emails.layout')

@section('content')
    <p>
        @lang('emails.dear_firstname_lastname', ['firstname' => $user->Keresztnev, 'lastname' => $user->Vezeteknev ])
    </p>

    <p>A <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>-hoz tartozó felhasználói fiókod jelszavát sikeresen
        módosítottad.</p>

    <p>Amennyiben nem te kezdeményezted a jelszó megváltoztatását, kérjük, hogy jelezd az <a
            href="mailto: info@riel.hu">info@riel.hu</a> e-mail címen.</p>

    @include('emails.includes.footer')
@endsection
