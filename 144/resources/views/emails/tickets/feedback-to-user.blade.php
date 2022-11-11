@extends('emails.layout')

@section('content')
    <p>
        Kedves {{ $name }}!
    </p>
    <p>Köszönjük, hogy a RIEL Elektronikai Kft. műszaki terméktámogatásához fordultál! Ügyeletünk munkanapokon 8 és 18
        óra között dolgozik, ahogy tudunk reagálunk az üzenetedre.</p>
    <table class="table">
        <tr>
            <td class="label">Név:</td>
            <td>{{ $name }}</td>
        </tr>
        <tr>
            <td class="label">E-mail:</td>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <td class="label">Telefon:</td>
            <td>{{ $phone }}</td>
        </tr>
        <tr>
            <td class="label">Üzenet:</td>
            <td>{{ $content }}</td>
        </tr>
    </table>

    <p><b>Jelszó visszaállítás esetén</b> munkaidőben igyekszünk <b>15-30 percen belül küldeni</b> a szükséges fájlt,
        <b>köszönjük a
            türelmet!</b></p>

    <p><b>Kérünk, hogy az e-mail tárgyát a további levelezés során ne változtasd meg!</b> Ha hivatkozni szeretnél erre a
        hibajegyre, a levélben található azonosítóval teheted meg.</p>

    <p>Amíg mi a hiba elhárításának dolgozzunk, iratkozz fel a <a
            href="https://www.youtube.com/channel/UCDN7T-SC48x9zuOFMGIGm0Q">RIEL YouTube</a> csatornájára, ahol a
        rengeteg hasznos útmutató videónk között lehet, hogy a választ is megtalálod.</p>

    @include('emails.includes.footer')

    <table>
        <tr>
            <td class="separator"></td>
        </tr>
    </table>


    <p>Support telefon: +36 1 236 8092 | Support mobil: +36 20 890 0702</p>

@endsection
