@extends('emails.layout')

@section('content')

    <p>Kedves Kolléga!</p>

    <p>A <a href="https://www.riel.hu/">www.riel.hu</a> weboldalon új regisztráció érkezett.</p>

    <h1>A regisztráció részletei:</h1>
    <br>

    <h2>Személyes és cégadatok</h2>

    <table class="mb-4">
        <tr>
            <td class="label">@lang('form.email'):</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.name'):</td>
            <td>{{ $user->Vezeteknev }} {{ $user->Keresztnev }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.position'):</td>
            <td>{{ $user->Beosztas }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.mobile'):</td>
            <td>{{ $user->Mobil }}</td>
        </tr>
        @isset($user->Telefon)
        <tr>
            <td class="label">@lang('form.phone'):</td>
            <td>{{ $user->Telefon }}</td>
        </tr>
        @endisset
        @isset($user->Fax)
        <tr>
            <td class="label">@lang('form.fax'):</td>
            <td>{{ $user->Fax }}</td>
        </tr>
        @endisset
    </table>

    <h2>Számlázási cím</h2>

    <table class="mb-4">
        <tr>
            <td class="label">@lang('form.country'):</td>
            <td>{{ $user->country->Nev }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.zip_code'):</td>
            <td>{{ $user->IrSzam }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.city'):</td>
            <td>{{ $user->Helyseg }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.address'):</td>
            <td>{{ $user->UtcaHSzam }}</td>
        </tr>
    </table>

    <p><a href="{{ config('riel.titan_app_url') }}/web-users">Tovább az összekötéshez</a></p>

    @include('emails.includes.footer')
@endsection
