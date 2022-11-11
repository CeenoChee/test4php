@extends('emails.layout')

@section('content')
    <p>
        @lang('emails.dear_firstname_lastname', ['firstname' => $user->Keresztnev, 'lastname' => $user->Vezeteknev ])
    </p>
    <p>
        @lang('emails.you_have_invited', ['name' => $adminUser->getName()])
    </p>

    <table class="mb-4">
        <tr>
            <td class="label">@lang('form.email'):</td>
            <td>{{ $adminUser->getEmail() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.company_name'):</td>
            <td>{{ $adminUser->getCompanyName() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.address'):</td>
            <td>{{ $adminUser->getAddress()->withoutName() }}</td>
        </tr>
    </table>

    <p>
        @lang('emails.click_the_invitation_link'):<br/>
        <a href="{{ route('employee.invite.confirmation', ['locale' => app('Lang')->getLocale(),'token' => $user->token], true) }}">{{ route('employee.invite.confirmation', ['locale' => app('Lang')->getLocale(),'token' => $user->token], true) }}</a>
    </p>

    <h2>@lang('form.personal_data'):</h2>

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

    @include('emails.includes.footer')
@endsection
