@extends('emails.layout')

@section('content')
    <p>
        Kedves munkatárs!
    </p>
    <p>
        A RIEL hibajegy oldaláról az alábbi üzenetet küldték:
    </p>

    <table class="table">
        <tr>
            <td class="label">Küldő neve:</td>
            <td>{{ $name }}</td>
        </tr>
        <tr>
            <td class="label">Küldő e-mail címe:</td>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <td class="label">Küldő telefon:</td>
            <td>{{ $phone }}</td>
        </tr>
        <tr>
            <td class="label">Üzenet:</td>
            <td>{{ $content }}</td>
        </tr>
    </table>

    @include('emails.includes.footer')
@endsection
