<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE"/>

    <style>
        .rby, .rby table, .rby td, .rby p, .rby a, .rby li, .rby blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        .rby table {
            color: #606063;
            margin: 0px;
            border-collapse: collapse;
        }

        .rby table td.label {
            min-width: 200px;
        }

        .rby, .rby .bodyTable, .rby .bodyCell {
            width: 100% !important;
            height: 100% !important;
            margin: 0;
            padding: 0;
            font-family: helvetica neue, helvetica, arial, sans-serif;
            font-size: 14px;
        }

        .rby .bodyContent {
            padding: 1rem;
        }

        .rby table, .rby td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            padding: 3px;
        }

        .rby table.small-font {
            font-size: 11px;
        }

        .rby table .bordered td {
            border-bottom: 1px solid #589fd9;
        }

        .rby table .border-bottom th,
        .rby table .border-bottom td {
            border-bottom: 2px solid #589fd9;
        }

        .rby table .border-top th,
        .rby table .border-top td {
            border-top: 2px solid #589fd9;
        }

        .rby th {
            text-align: left;
            padding: 5px 0;
        }

        .right {
            text-align: right;
        }

        .strong {
            font-weight: 600;
        }

        .rby img, .rby a img {
            border: 0;
            outline: none;
            text-decoration: none;
        }

        .rby h1, .rby h2, .rby h3, .rby h4, .rby h5, .rby h6 {
            margin: 0;
            padding: 0;
            color: #555555;
            font-weight: bold;
            font-size: 14px;
        }

        .rby h1 {
            margin-bottom: 30px;
        }

        .rby p {
            margin: 1em 0;
            padding: 0;
            line-height: 20px;
            color: #555555;
        }

        .rby .fullwidth {
            width: 100%;
        }

        .rby .italic {
            font-style: italic;
        }

        .rby .logo {
            padding: 8px;
            text-align: center;
        }

        .rby .riellogo {
            width: 83px;
            height: 83px;
        }

        .rby .separator {
            width: 600px;
            height: 4px;
            background-image: url('{{ asset('assets/images/social/separator.png') }}');
            background-repeat: no-repeat;
            display: block;
        }

        .rby table.social {
            margin-top: 25px;
            margin-bottom: 30px;
        }

        .rby .social td {
            padding: 0 14px;
        }

        .rby .social a {
            display: block;
            width: 24px;
            height: 24px;
            background-size: 24px 24px;
            background-repeat: no-repeat;
        }

        .rby .social a.web {
            background-image: url('{{ asset('assets/images/social/web.png') }}');
        }

        .rby .social a.linkedin {
            background-image: url('{{ asset('assets/images/social/linkedin.png') }}');
        }

        .rby .social a.youtube {
            background-image: url('{{ asset('assets/images/social/youtube.png') }}');
        }

        .rby .social a.facebook {
            background-image: url('{{ asset('assets/images/social/facebook.png') }}');
        }

        .rby .social a.email {
            background-image: url('{{ asset('assets/images/social/email.png') }}');
        }

        .rby .address {
            padding: 14px;
            font-size: 12px;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            color: #666;
        }

        .rby .address a {
            color: #666;
        }

        .rby .copyright {
            font-size: 10px;
            line-height: 16px;
            color: #666;
        }

        .rby a {
            color: #6dc6dd;
            text-decoration: none;
        }

        .rby a:hover {
            color: #1d659e;
        }

        .rby .mb-4 {
            margin-bottom: 30px;
        }

        .rby ul li {
            margin-bottom: 5px;
        }

        .dev-header{
            padding: 10px;
            background-color: #d28a00;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .rby .pl-1 {
            padding-left: 1rem !important;
        }

        .rby .py-1 {
            padding: 1rem 0 !important;
        }

        .rby td{
            vertical-align: baseline;
        }
    </style>
</head>
<body class="rby">
<center>
    @include('layouts.includes.dev-header')
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="bodyTable">
        <tr>
            <td align="center" class="bodyCell">
                <table border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                        <td class="logo">
                            <a href="https://www.riel.hu/"><img class="riellogo"
                                                                src="{{ asset('assets/images/riellogo.png') }}"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div class="separator"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="bodyContent">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div class="separator"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table class="fullwidth">
                                <tr>
                                    <td align="center">
                                        <table class="social">
                                            <tr>
                                                <td>
                                                    <a href="https://www.riel.hu/" class="web"></a>
                                                </td>
                                                <td>
                                                    <a href="https://www.linkedin.com/company/riel-elektronikai-kft-"
                                                       class="linkedin"></a>
                                                </td>
                                                <td>
                                                    <a href="https://www.youtube.com/channel/UCDN7T-SC48x9zuOFMGIGm0Q"
                                                       class="youtube"></a>
                                                </td>
                                                <td>
                                                    <a href="https://www.facebook.com/rielkft" class="facebook"></a>
                                                </td>
                                                <td>
                                                    <a href="mailto: info@riel.hu" class="email"></a>
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="address" align="center">
                                        RIEL Elektronikai Kft. - <a
                                            href="https://www.google.hu/maps/dir//Budapest,+Frangepán+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangepán+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025">1139
                                            Budapest, Röppentyű u. 24.</a> - Tel: <a href="tel:+3612368090">+36 (1) 236
                                            8090</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="copyright" align="center">
                                        @lang('emails.copyright_text')<br/>
                                        Copyright © {{ now()->year }} RIEL Elektronikai Kft. - @lang('emails.copyright')
                                        .
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>
</body>
</html>
