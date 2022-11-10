@extends('layouts.app')

@section('title')
    @lang('pages/contact.contact')
@endsection

@section('content_title')
    @lang('pages/contact.contact')
@endsection

@section('meta_description')
    @lang('pages/contact.contact_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('contact') }}
@endsection
@section('content')

    <div
        class="z-10 text-center md:text-left md:absolute md:ml-4 md:mt-24 py-8 pb-1 md:px-12 bg-[#fff] md:left-96 border border-solid border-neutral-200">
        <img class="hidden md:block z-20 absolute w-16 h-16 -top-8 left-1/2 rounded-full -translate-x-1/2"
             src="{{ asset('assets/images/riellogo.png') }}">
        <h2 class="text-riel-light text-lg font-bold">@lang('form.address')</h2>
        <ul class="mb-4">
            <li class="font-bold text-gray-600">
                <a class="absolute -ml-6 text-riel-light"
                   href="https://www.google.hu/maps/dir//Budapest,+Frangep%C3%A1n+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangep%C3%A1n+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025"
                   target="_blank"><i class="fal fa-location"></i></a>
                RIEL Elektronikai Kft.
            </li>
            <li class="text-sm">
                <a href="https://www.google.hu/maps/dir//Budapest,+Frangep%C3%A1n+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangep%C3%A1n+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025"
                   target="_blank">
                    1139 Budapest, Röppentyű utca 24.
                </a>
            </li>
        </ul>
        <h3 class="font-bold text-riel-light">@lang('pages/contact.store_service')</h3>
        <ul class="mb-4">
            <li>@lang('pages/contact.opening_hours'): @lang('pages/contact.opening_hours_content')</li>
        </ul>
        <h3 class="font-bold text-riel-light">@lang('pages/contact.technical_support')</h3>
        <ul class="mb-4">
            <li>@lang('pages/contact.technical_support_content')</li>
            <br/>
            <li>@lang('pages/contact.opening_hours'): @lang('pages/contact.opening_hours_content_support')</li>
        </ul>
    </div>
    <div id="map" class="w-full h-80 border-b-2 border-solid border-neutral-300"></div>

    <div
        class="z-10 text-center md:text-left md:absolute md:ml-4 md:mt-24 py-8 px-12 bg-[#fff] md:right-96 border border-solid border-neutral-200 pb-1">
        <img class="hidden md:block z-20 absolute w-16 h-16 -top-8 left-1/2 rounded-full -translate-x-1/2"
             src="{{ asset('assets/images/riellogo.png') }}">
        <h2 class="text-riel-light text-lg font-bold">@lang('form.address')</h2>
        <ul class="mb-4">
            <li class="font-bold text-gray-600">
                <a class="absolute -ml-6 text-riel-light"
                   href="https://www.google.com/maps/dir//RIEL+Raktár,+Dunakeszi,+Pallag+u+31-D1,+2120/@47.6127878,19.1160581,17z"
                   target="_blank"><i class="fal fa-location"></i></a>
                @lang('pages/contact.riel_warehouse')
            </li>
            <li>
                <a href="https://www.google.com/maps/dir//RIEL+Raktár,+Dunakeszi,+Pallag+u+31-D1,+2120/@47.6127878,19.1160581,17z"
                   target="_blank">
                    2120 Dunakeszi, Pallag u. 31. D1-D2 kapu
                </a>
            </li>
            <br/>
            <li>@lang('pages/contact.opening_hours'): @lang('pages/contact.opening_hours_content')</li>
        </ul>
    </div>
    <div id="map_dk" class="w-full h-80"></div>


    <div
        class="grid grid-cols-1 grid-rows-5 md:grid-cols-2 md:grid-rows-3 lg:grid-cols-3 lg:grid-rows-2 gap-4 md:gap-4 xl:gap-16 text-center mt-16">

        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md bg-white">
            <div class="text-2xl text-riel-light mb-4">
                <i class="fal fa-car-building"></i>
            </div>
            <h3 class="font-light text-xl mb-4">
                @lang('pages/contact.shop')
            </h3>
            <div class="text mb-4">
                @lang('pages/contact.shop_content')
            </div>

            <table class="mx-auto border border-solid border-[#eee]">
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-at"></i></td>
                    <td class="py-1 px-6"><a href="mailto:rendeles@riel.hu">rendeles@riel.hu</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-phone"></i></td>
                    <td class="py-1 px-6"><a href="tel:+3612368090">+36 (1) 236 8090</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-mobile"></i></td>
                    <td class="py-1 px-6"><a href="tel:+36208900700">+36 (20) 890 0700</a></td>
                </tr>
            </table>
        </div>

        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md bg-white">
            <div class="text-2xl text-riel-light mb-4">
                <i class="fal fa-analytics"></i>
            </div>
            <h3 class="font-light text-xl mb-4">
                @lang('pages/contact.sales')
            </h3>
            <div class="text mb-4">
                @lang('pages/contact.sales_content')
            </div>

            <table class="mx-auto border border-solid border-[#eee]">
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-at"></i></td>
                    <td class="py-1 px-6"><a href="mailto:ajanlat@riel.hu">ajanlat@riel.hu</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-phone"></i></td>
                    <td class="py-1 px-6"><a href="tel:+3612368096">+36 (1) 236 8096</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-mobile"></i></td>
                    <td class="py-1 px-6"><a href="tel:+36208900706">+36 (20) 890 0706</a></td>
                </tr>
            </table>
        </div>


        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md bg-white">
            <div class="text-2xl text-riel-light mb-4">
                <i class="fal fa-user-cog"></i>
            </div>
            <h3 class="font-light text-xl mb-4">
                @lang('pages/contact.technical_support')
            </h3>
            <div class="text mb-1">
                @lang('pages/contact.technical_support_content')
            </div>

            <div class="font-semibold mb-4">
                @lang('pages/contact.videotechnika')
            </div>

            <table class="mx-auto border border-solid border-[#eee]">
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-at"></i></td>
                    <td class="py-1 px-6"><a href="mailto:support@riel.hu">support@riel.hu</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-phone"></i></td>
                    <td class="py-1 px-6"><a href="tel:+3612368092">+36 (1) 236 8092</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-mobile"></i></td>
                    <td class="py-1 px-6"><a href="tel:+36208900702">+36 (20) 890 0702</a></td>
                </tr>
            </table>
        </div>


        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md bg-white">
            <div class="text-2xl text-riel-light mb-4">
                <i class="fal fa-user-cog"></i>
            </div>
            <h3 class="font-light text-xl mb-4">
                @lang('pages/contact.technical_support')
            </h3>
            <div class="text mb-1">
                @lang('pages/contact.technical_support_content')
            </div>
            <div class="font-semibold mb-4">
                @lang('pages/contact.intrusion')
            </div>

            <table class="mx-auto border border-solid border-[#eee]">
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-at"></i></td>
                    <td class="py-1 px-6"><a href="mailto:support@riel.hu">support@riel.hu</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-phone"></i></td>
                    <td class="py-1 px-6"><a href="tel:+3612368093">+36 (1) 236 8093</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-mobile"></i></td>
                    <td class="py-1 px-6"><a href="tel:+36208900703">+36 (20) 890 0703</a></td>
                </tr>
            </table>
        </div>

        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md bg-white">
            <div class="text-2xl text-riel-light mb-4">
                <i class="fal fa-user-cog"></i>
            </div>
            <h3 class="font-light text-xl mb-4">
                @lang('pages/contact.repair_center')
            </h3>
            <div class="text mb-4">
                @lang('pages/contact.repair_center_content')
            </div>

            <table class="mx-auto border border-solid border-[#eee]">
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-at"></i></td>
                    <td class="py-1 px-6"><a href="mailto:szerviz@riel.hu">szerviz@riel.hu</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-phone"></i></td>
                    <td class="py-1 px-6"><a href="tel:+3612368097">+36 (1) 236 8097</a></td>
                </tr>
                <tr>
                    <td class="py-1 px-4 bg-[#eee]"><i class="fal fa-mobile"></i></td>
                    <td class="py-1 px-6"><a href="tel:+36208900707">+36 (20) 890 0707</a></td>
                </tr>
            </table>
        </div>
    </div>

@endsection


@section('bottom')

    <div class="bg-gradient-to-r from-riel-dark to-riel-light mt-6 text-white">

        <div class="mx-auto px-8 w-full lg:w-1/2 xl:w-1/3 lg:px-0 py-8">

            <h2 class="font-light text-center pb-10 text-xl">@lang('pages/contact.write_us')</h2>

            <form method="POST" action="{{ route('contact.post', ['locale' => app('Lang')->getLocale()]) }}"
                  id="contact-form">
                @if(config('app.env') === 'production')
                    {!! app('captcha')->render(app('Lang')->getLocale()) !!}
                @endif

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="w-full">
                        <label for="name" class="required text-white">@lang('form.name')</label>
                        <input id="name" type="text" placeholder="@lang('form.placeholder.name')"
                               class="{{ $errors->has('name') ? ' invalid' : '' }} w-full mb-0" name="name"
                               value="{{ old('name') }}" required>
                        <x-input-error :field="'name'"/>
                    </div>

                    <div class="w-full">
                        <label for="email" class="required text-white">@lang('form.email')</label>
                        <input id="email" type="email" placeholder="@lang('form.placeholder.email')"
                               class="{{ $errors->has('email') ? ' invalid' : '' }}" name="email"
                               value="{{ old('email') }}" required>
                        <x-input-error :field="'email'"/>
                    </div>
                </div>


                <div class="w-full">
                    <label for="message" class="required text-white">@lang('form.message')</label>
                    <textarea id="message" placeholder="@lang('pages/contact.placeholder.message')"
                              class="{{ $errors->has('message') ? ' invalid' : '' }}"
                              name="message" rows="4" cols="50" required></textarea>
                    <x-input-error :field="'message'"/>

                </div>

                <div class="text-center">
                    <button type="submit" class="btn">@lang('form.submit')</button>
                </div>

            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 47.534763, lng: 19.074025},
                zoom: 17
            });
            var map_dk = new google.maps.Map(document.getElementById('map_dk'), {
                center: {lat: 47.612816, lng: 19.119838},
                zoom: 16
            });
            var icon_1 = {
                url: '{{ asset("assets/images/contact/riel-maps.png") }}',
                size: new google.maps.Size(34, 60),
                origin: new google.maps.Point(0, 0),
            };
            var marker_1 = new google.maps.Marker({
                position: {lat: 47.534631, lng: 19.074544},
                icon: icon_1,
                map: map,
                title: 'RIEL Elektronikai Kft.',
                url: 'https://www.google.com/maps/dir//Budapest,+Riel+Elektronikai+Kft.,+R%C3%B6ppenty%C5%B1+u.+24,+1139+Magyarorsz%C3%A1g/@47.5346736,19.074025,17z/data=!4m9!4m8!1m0!1m5!1m1!1s0x4741dbeab8b26621:0x3561ddc72844ebc1!2m2!1d19.0745321!2d47.53463!3e0'
            });
            var icon_2 = {
                url: '{{ asset("assets/images/contact/parking-maps.png") }}',
                size: new google.maps.Size(40, 52),
                origin: new google.maps.Point(0, 0),
            };
            var icon_3 = {
                url: '{{ asset("assets/images/contact/riel-dk.png") }}',
                size: new google.maps.Size(34, 60),
                origin: new google.maps.Point(0, 0),
            };
            var marker_2 = new google.maps.Marker({
                position: {lat: 47.535303, lng: 19.074523},
                icon: icon_2,
                map: map,
                title: 'RIEL Elektronikai Kft. - Parkoló',
                url: 'https://www.google.com/maps/dir//Budapest,+Frangepán+utca+23/@47.5353061,19.072329,17z/data=!4m9!4m8!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025!3e0'
            });
            var marker_3 = new google.maps.Marker({
                position: {lat: 47.612916, lng: 19.117838},
                icon: icon_3,
                map: map_dk,
                title: 'RIEL Elektronikai Kft.',
                url: 'https://www.google.com/maps/dir//Dunakeszi,+Pallag+utca+17/@47.612816,19.117838,17z'
            });
            map.addListener('zoom_changed', function () {
                if (map.getZoom() < 16) {
                    setMapOnAll(null, marker_2);
                } else {
                    setMapOnAll(map, marker_2);
                }
            })
            google.maps.event.addListener(marker_1, 'click', function () {
                window.location.href = this.url;
            });
            google.maps.event.addListener(marker_2, 'click', function () {
                window.location.href = this.url;
            });
            google.maps.event.addListener(marker_3, 'click', function () {
                window.location.href = this.url;
            });
        }

        function setMapOnAll(map, marker_2) {
            marker_2.setMap(map);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOue0brkLSPjDyv8sN1wpwrNQNtZfh2c8&callback=initMap"
            async defer></script>
@endpush
