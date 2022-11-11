@extends('emails.layout')

@section('content')
    <p>
        @lang('emails.dear_name', ['name' => $name])
    </p>
    <p>
        @lang('emails.received_your_message')
    </p>

    <p>
        @lang('form.colleagues_will_contact')
    </p>

    <h2>@lang('emails.message_details')</h2><br />

    <strong>@lang('emails.sender_name'):</strong> {{ $name }}<br />
    <strong>@lang('emails.sender_email'):</strong> {{ $email }}<br />
    <strong>@lang('form.message'):</strong> {{ $content }}

    @include('emails.includes.footer')
@endsection
