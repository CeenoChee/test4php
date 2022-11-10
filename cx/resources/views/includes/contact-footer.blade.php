<div class="bg-gradient-to-r from-riel-dark to-riel-light pt-14 pb-6">

    <div class="container mx-auto">

        @if(!LUrl::routeIs('contact'))
        <div class="gap-12 lg:flex justify-center">


            <div class="text-center flex flex-col mb-4 lg:mb-0">

                <div class="grow">
                    <i class="fa fa-phone text-sky-800 text-xl mb-4"></i>

                    <div class="uppercase mb-2 text-xs text-gray-300">
                        @lang('pages/contact.call_us')
                    </div>

                    <h3 class="text-2lg mb-4 text-cyan-300 ">
                        @lang('form.phone')
                    </h3>

                </div>

                <div class="justify-center flex gap-4 lg:mt-4">
                    <div>
                        <a href="tel:+36208900700"
                           class="w-[20rem] block py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md hover:to-sky-400 ">
                            +36 (20) 890 0700
                        </a>
                    </div>
                </div>

            </div>



            <div class="text-center flex flex-col mb-4 lg:mb-0">

                <div class="grow">
                    <i class="fa fa-envelope text-sky-800 text-xl mb-4"></i>

                    <div class="uppercase mb-2 text-xs text-gray-300">
                        @lang('pages/contact.write_us')
                    </div>

                    <h3 class="text-2lg mb-4 text-cyan-300 ">
                        @lang('pages/contact.message')
                    </h3>

                </div>

                <div class="justify-center flex gap-4 lg:mt-4">
                    <div>
                        <a href="mailto:ajanlat@riel.hu"
                           class="w-[20rem] block py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md hover:to-sky-400 ">
                            ajanlat@riel.hu
                        </a>
                    </div>
                </div>

            </div>


            <div class="text-center flex flex-col mb-4 lg:mb-0">

                <div class="grow">

                    <i class="fa fa-map-marker-alt text-sky-800 text-xl mb-4"></i>

                    <div class="uppercase mb-2 text-xs text-gray-300">
                        @lang('pages/contact.visit_us')
                    </div>

                    <h3 class="text-2lg mb-4 text-cyan-300">
                        @lang('pages/contact.our_address')
                    </h3>
                </div>

                <div class="justify-center flex gap-4 lg:mt-4">
                    <div>
                    <a target="_blank"
                       href="https://www.google.hu/maps/dir//Budapest,+Frangep%C3%A1n+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangep%C3%A1n+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025"
                       class="w-[20rem] block py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md hover:to-sky-400">
                        Budapest 1139, Frangepán u. 23.
                    </a>
                    </div>


                </div>


            </div>

        </div>
        @endif

        <hr class="mb-6 mt-10">

        <ul class="text-center">
            <li class="inline-block"><a href="{{ LUrl::route('terms') }}" class="text-white hover:text-cyan-200">@lang('pages/terms.terms')</a></li>
            <i class="fa-solid fa-circle text-cyan-200 scale-50 mx-2"></i>
            <li class="inline-block"><a href="{{ LUrl::route('privacy') }}" class="text-white hover:text-cyan-200">@lang('pages/privacy.title')</a></li>
            <i class="fa-solid fa-circle text-cyan-200 scale-50 mx-2"></i>
            @if (app('Lang')->getLocale() == 'hu')
                <li class="inline-block"><a href="{{ LUrl::route('career') }}" class="text-white hover:text-cyan-200">@lang('pages/career.career')</a></li>
                <i class="fa-solid fa-circle text-cyan-200 scale-50 mx-2"></i>
            @endif
            <li class="inline-block"><a href="{{ LUrl::route('faq') }}" class="text-white hover:text-cyan-200">@lang('pages/faq.faq')</a></li>
            <i class="fa-solid fa-circle text-cyan-200 scale-50 mx-2"></i>
            <li class="inline-block"><a href="{{ LUrl::route('warranty') }}" class="text-white hover:text-cyan-200">@lang('pages/warranties.warranty')</a></li>
            <i class="fa-solid fa-circle text-cyan-200 scale-50 mx-2"></i>
            <li class="inline-block"><a href="{{ LUrl::route('contact') }}" class="text-white hover:text-cyan-200">@lang('pages/contact.contact')</a>
        </ul>



    </div>
</div>
