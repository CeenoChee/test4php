@extends('emails.layout')

@section('content')
    <p>
        @lang('emails.dear_firstname_lastname', ['firstname' =>$user->Keresztnev, 'lastname' => $user->Vezeteknev ])
    </p>
    <p>
        @lang('emails.click_on_the_link_to_register')<br/>
        <a href="{{ LUrl::route('auth.verity', ['token' => $user->token], true) }}">{{ LUrl::route('auth.verity', ['token' => $user->token], true) }}</a>
    </p>

    <h2>@lang('form.personal_data'):</h2>

    <table>
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
            <td class="label">@lang('form.phone_number'):</td>
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

    <h2>@lang('form.billing_address'):</h2>

    <table>
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
            <td class="label">@lang('form.city'):</td>
            <td>{{ $user->Helyseg }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.address'):</td>
            <td>{{ $user->UtcaHSzam }}</td>
        </tr>
    </table>

    @include('emails.includes.footer')
@endsection
