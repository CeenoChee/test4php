@extends('emails.layout')

@section('content')
    <h1>@lang('emails.the_employee_activated_himself')</h1>

    <h2>@lang('form.company_data'):</h2>

    <table class="mb-4">
        <tr>
            <td class="label">@lang('form.company_name'):</td>
            <td>{{ $user->getCompanyName() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.address'):</td>
            <td>{{ $user->getAddress()->withoutName() }}</td>
        </tr>
    </table>

    <h2>@lang('form.personal_data'):</h2>

    <table class="mb-4">
        <tr>
            <td class="label">@lang('form.email'):</td>
            <td>{{ $user->getEmail() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.name'):</td>
            <td>{{ $user->getName() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.position'):</td>
            <td>{{ $user->getPosition() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.phone_number'):</td>
            <td>{{ $user->getPhone() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.mobile'):</td>
            <td>{{ $user->getMobile() }}</td>
        </tr>
        <tr>
            <td class="label">@lang('form.fax'):</td>
            <td>{{ $user->getFax() }}</td>
        </tr>
    </table>
@endsection
