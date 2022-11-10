@extends('emails.layout')

@section('content')
    <p>
        Kedves munkatárs!
    </p>
    <p>
        A RIEL kapcsolat oldaláról az alábbi üzenetet küldték:<br /><br />
        <strong>Név:</strong> {{ $name }}<br />
        <strong>E-mail:</strong> {{ $email }}<br />
        <strong>Üzenet:</strong> {{ $content }}
    </p>
    @include('emails.includes.footer')
@endsection
