<nav class="text-white fixed w-full z-40 main-menu">
    <div class="md:px-0 md:container xl:px-32 md:mx-auto md:text-center flex items-center">

        <li class="toggleable lg:hidden list-none">
            <input type="checkbox" value="selected" id="toggle-mobile-menu" class="toggle-input">
            <label for="toggle-mobile-menu" class="inline-block cursor-pointer hover:text-sky-300 label-mobile-icon scale-75">

                <div id="nav-icon2">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

            </label>
            <div role="toggle"
                 class="bg-white p-6 mb-16 sm:mb-0 shadow-xl z-50 small-menu nav-menu w-full top-[50px]">
                <ul class="text-center">
                    <li class="py-4 border-b border-neutral-300 uppercase">
                        <a href="{{ LUrl::route('product.category.main')}}"
                           class="hover:text-sky-300">@lang('pages/products.products')</a>
                    </li>
                    <li class="py-4 border-b border-neutral-300 uppercase">
                        <a href="{{LUrl::route('support')}}"
                           class="hover:text-sky-300">@lang('pages/supports.support')</a>
                    </li>
                    <li class="py-4 border-b border-neutral-300 uppercase">
                        <a href="{{LUrl::route('divisions')}}"
                           class="hover:text-sky-300">@lang('pages/divisions.title')</a>
                    </li>
                    <li class="py-4 border-b border-neutral-300 uppercase">
                        <a class="hover:text-sky-300" href="https://training.riel.hu">@lang('pages/academy.academy')</a>
                    </li>
                    <li class="py-4 border-b border-neutral-300 uppercase">
                        <a class="hover:text-sky-300"
                           href="{{LUrl::route('contact')}}">@lang('pages/contact.contact')</a>
                    </li>

                    @include('pages.knowledges.includes.sidebar.contacts')

                    <li class="pr-4 mt-2 mx-auto text-sm">
                        <div class="py-1 rounded-md px-4 text-center bg-sky-400 text-sky-800">
                            <div class="mb-1 font-normal">
                                <i class="fa-light mr-1 fa-map-marker-alt"></i> @lang('form.address')
                            </div>
                            <a href="https://www.google.hu/maps/dir//Budapest,+Frangep%C3%A1n+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangep%C3%A1n+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025" target="_blank">
                                1139 Budapest, Röppentyű utca 24.
                            </a>
                        </div>
                    </li>

                </ul>


            </div>
        </li>


        <a href="/" class="logo w-[50px] h-[50px] lg:w-[70px] lg:h-[70px] lg:absolute top-[5px] rounded-full p-1 z-30">
            <img src="{{asset('/assets/images/riellogo.png')}}"
                 class="w-[50px] lg:w-[70px] lg:mx-auto inline-block shadow-logo rounded-full">
        </a>


        <ul class="grow font-bold hidden lg:block">

            @include('layouts.includes.nav.products')

            @include('layouts.includes.nav.supports')

            @include('layouts.includes.nav.divisions')

            <li class="inline-block uppercase p-4">
                <a class="text-white hover:text-sky-300" href="https://training.riel.hu">@lang('pages/academy.academy')</a>
            </li>
            <li class="inline-block uppercase p-4">
                <a class="text-white hover:text-sky-300" href="{{LUrl::route('contact')}}">@lang('pages/contact.contact')</a>
            </li>
        </ul>

        <div class="flex-none text-2lg text-white ml-auto mr-0">

            <li class="inline-block mx-2">
                <div id="search-wrapper">
                    @php $user = app('User') @endphp
                    <search url="{{ route('search.data', ['locale' => app('Lang')->getLocale()]) }}"
                            rielactive="{{ $user->isRielActive() }}"
                            locale="{{ app('Lang')->getLocale() }}"
                            tooltip="@lang('global.search')" ref="main_search"></search>
                </div>
            </li>

            @php
                $lang = app('Lang');
                $locale = $lang->getLocale();
            @endphp
            <li class="toggleable inline-block mx-2">
                <input type="checkbox" value="selected" id="toggle-lang" class="toggle-input">
                <label for="toggle-lang"
                       class="inline-block cursor-pointer uppercase  rounded-md hover:text-sky-300">
                    <div class="lang-button button" data-state="inactive" data-category-id="lang">
                        <span class="text-[0.5rem] ml-[4px] absolute uppercase"
                              style="margin-top: 1px">{{ $locale }}</span>
                        <i class="fal fa-circle"></i>
                    </div>
                </label>
                <div role="toggle"
                     class="bg-white p-6 mb-16 sm:mb-0 shadow-xl z-50 top-[45px] small-menu nav-menu">
                    <ul>
                        @foreach($lang->getLanguages() as $language)
                            @if($language->KodAlpha2 !== $locale)
                                <li>
                                    <a href="{{ $lang->getUrl($language->KodAlpha2) }}" title="{{ $language->Nev }}"
                                       class="!text-riel-light font-semibold uppercase">
                                        {{ $language->KodAlpha2 }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>

            @if(Auth::check() && $user->hasOrderPermission())
                <li class="inline-block mx-2">
                    <a class="text-white hover:text-sky-300 relative" href="{{LUrl::route('cart')}}">
                        <i class="fal fa-shopping-bag"></i>

                        <span id="cart-qty"
                              class="bg-white text-riel-light rounded-full absolute text-2xs w-[20px] top-[15px] left-[10px] text-center font-bold @if(app('Cart')->getCount() > 0) block @else hidden @endif">
                            {{ app('Cart')->getCount() }}
                        </span>
                    </a>
                </li>
            @endif

            @if(!Auth::check())
                <li class="inline-block mx-2">
                    <a href="{{LUrl::route('login')}}" class="text-white hover:text-sky-300" title="@lang('pages/auth.login')">
                        <i class="fal fa-circle-user "></i>
                    </a>
                </li>
            @else
                <li class="toggleable inline-block mx-2 relative">
                    <input type="checkbox" value="selected" id="toggle-auth" class="toggle-input">
                    @if(!$user->isRielActive()) <i class="fa-solid text-sm text-yellow-400 fa-triangle-exclamation absolute left-[15px] bottom-[15px]"></i> @endif
                    <label for="toggle-auth"
                           class="inline-block cursor-pointer uppercase  rounded-md hover:text-sky-300" title="@lang('pages/account.account')">
                        <i class="fa fa-user-circle "></i>
                    </label>
                    <div role="toggle"
                         class="bg-white p-6 mb-16 sm:mb-0 shadow-xl z-50 top-[35px] small-menu nav-menu profile-menu">
                        @include('includes.profile-menu', ['header' => true])
                    </div>
                </li>
            @endif

        </div>
    </div>
</nav>


@push('scripts')
    <script>
        $(document).ready(function(){
            $('#nav-icon2').click(function(){
                $(this).toggleClass('mobile-open');
            });
        });
    </script>
@endpush
