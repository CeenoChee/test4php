<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<!-- Version: {{ config('app.version') }} -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="installer_price_save"
          content="{{ route('installer.price.save', ['locale' => app('Lang')->getLocale()]) }}">

    <meta name="google-site-verification" content="kO3pf-Y5AC8_kbaidst-ZitEbaUTUdmazayofGxB0Ss"/>
    @if (App::environment(['local', 'staging']))
        <meta name="robots" content="noindex, nofollow">
    @endif

    @if (trim($__env->yieldContent('structured_data')))
    <!-- Structured data -->
        <script type="application/ld+json">
            @yield('structured_data')
        </script>
    @endif

<!-- SEO data -->
    <title>@yield('title')</title>
    @if (trim($__env->yieldContent('meta_description')))
        <meta name="description" content="{{ trim($__env->yieldContent('meta_description')) }}">
    @endif

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Styles -->
    <link href="{{ mix('css/tailwind.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('head')
</head>
<body>
<div id="app" class="text-sm font-body text-gray-900 bg-[#f5f5f5]">

    @include('layouts.includes.main-menu')

    @include('layouts.includes.dev-header')

    <main class="blurable">
        @if (trim($__env->yieldContent('content_title')))
            <div class="bg-white shadow-md border-b border-solid border-neutral-200 pb-4 pt-16">

                <div class="text-center pt-6 container mx-auto">
                    <div class="text-center">
                        <h1 class="page-title leading-normal font-light text-3lg">{{ trim($__env->yieldContent('content_title')) }}</h1>
                    </div>
                    <div class="text-center">
                        @yield('breadcrumb')
                    </div>

                </div>

            </div>
        @endif

        @yield('top')

        <div
            class="container mx-auto px-2 sm:px-5 md:px-5 lg:px-16 xl:px-32 text-gray-600 leading-6 pb-10 pt-16">

            @if (flash()->message)
                <x-alert class="{{ flash()->class }}">
                    {{ flash()->message }}
                </x-alert>
            @endif

            @if ($errors->any())
                <x-alert class="alert-danger">
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </x-alert>
            @endif

            <div class="">

                @if($siteMessage)
                    <div
                        class="site-message-box content relative border border-riel-light bg-gradient-to-r from-riel-dark to-riel-light text-white text-lg py-4 px-6 rounded-md font-bold shadow-2xl @if(LUrl::routeIs('home')) mt-20 @else my-10 @endif">
                        <div class="pr-4 lg:pr-12">
                            <i class="fa fa-circle-info text-3lg"></i> {!! nl2br($siteMessage) !!}
                        </div>
                        @if(!LUrl::routeIs('home'))
                            <div class="ml-4 hover:cursor-pointer absolute top-[15px] right-[15px] close-site-message">
                                <i class="fa fa-times"></i>
                            </div>
                        @endif
                    </div>
                @endif

                @yield('content')
            </div>

        </div>

        @yield('bottom')

        @if(!LUrl::routeIs('support'))
            @include('includes.contact-footer')
        @endif

        <button id="to-top-button" onclick="goToTop()"
                class="hidden fixed z-90 bottom-6 right-6 border-0 w-10 h-10 rounded-full drop-shadow-md bg-riel-light text-white text-3xl font-bold opacity-70 hover:opacity-100">
            <i class="fa-solid fa-up text-lg relative bottom-[12px]"></i>
        </button>

    </main>

    @stack('modal')

    <footer class="blurable">
        @include('layouts.includes.footer')
    </footer>
</div>


<!-- Scripts -->
@translations
<script>window.locale = '{{ app('Lang')->getLocale() }}'</script>

<script src="{{ mix('js/jquery.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/scripts.js') }}"></script>

@stack('scripts')

</body>
</html>
