<div class="group inline-block">
    <li class="inline-block uppercase p-4 outline-none  flex items-center min-w-32">
        <span class="pr-1 font-bold flex-1">
            <a href="{{LUrl::route('support')}}" class="hover:text-sky-300 text-white">@lang('pages/supports.support')</a>
        </span>
        <span>
          @include('layouts.includes.nav.svg.arrow-y-svg')
        </span>
    </li>
    <ul class="support-menu z-30 pl-4 bg-riel-dark rounded-bl-md transform scale-0 group-hover:scale-100 w-60 absolute origin-top h-fit py-4" >
{{--        h-[410px]--}}

        <li class="rounded-l-full hover:bg-riel-light pr-4">
            <a href="{{ LUrl::route('download.categories.index') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1 flex">
                    <i class="fal mr-1 fa-download w-4 text-center !leading-[inherit]"></i>
                    <span>@lang('pages/downloads.downloads')</span>
                </span>

                @include('layouts.includes.nav.svg.arrow-x-svg')

            </a>

            <ul class="support-sub z-30 p-4 text-left bg-riel-light rounded-br-md absolute top-0 right-0 h-[410px] w-80">
                @foreach($mainMenuDownloadCategories as $mainMenuDownloadCategory)
                    @if($mainMenuDownloadCategory->downloads->count() > 0)
                            <li>
                                <a href="{{ LUrl::route('download.categories.show', ['downloadCategorySlug' => $mainMenuDownloadCategory->translation->slug]) }}"
                                   class="text-white rounded-md block py-1 text-gray-200 hover:text-white font-normal">
                                    {{ $mainMenuDownloadCategory->translation->name }}
                                </a>
                            </li>
                    @endif
                @endforeach

            </ul>
        </li>

        <li class="rounded-l-full hover:bg-riel-light pr-4">
            <a href="{{ LUrl::route('knowledge.index') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1 flex">
                    <i class="fal mr-1 fa-books w-4 text-center !leading-[inherit]"></i>
                   <span>@lang('pages/knowledge.knowledge')</span>
                </span>

                @include('layouts.includes.nav.svg.arrow-x-svg')
            </a>

            <ul class="support-sub p-4 text-left bg-riel-light rounded-br-md absolute top-0 right-0 h-[410px] w-80">
                @foreach($knowledgeCategories as $knowledgeCategory)
                    <li>
                        <a href="{{ LUrl::route('knowledge.category', ['slug' => $knowledgeCategory->translation->slug]) }}"
                           class="text-white rounded-md block py-1 text-gray-200 hover:text-white font-normal">
                            {{ $knowledgeCategory->translation->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="{{ LUrl::route('ticket') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1 flex">
                    <i class="fal mr-1 fa-tag w-4 text-center !leading-[inherit]"></i>
                    <span>@lang('pages/tickets.tickets')</span>
                </span>
            </a>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="{{ LUrl::route('videos.index') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1">
                    <i class="fal mr-1 fa-circle-play w-4 text-center"></i>
                  @lang('pages/videos.videos')
                </span>
            </a>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="{{ LUrl::route('faq') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1 flex">
                    <i class="fal mr-1 fa-circle-question w-4 text-center !leading-[inherit]"></i>
                    <span>@lang('pages/faq.faq')</span>
                </span>
            </a>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="{{ LUrl::route('warranty') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1 flex">
                    <i class="fal mr-1 fa-stamp w-4 text-center !leading-[inherit]"></i>
                    <span>@lang('pages/warranties.warranty')</span>
                </span>
            </a>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="{{ LUrl::route('repair') }}"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1 flex">
                    <i class="fal mr-1 fa-screwdriver-wrench w-4 text-center !leading-[inherit]"></i>
                    <span>@lang('pages/repair.repair')</span>
                </span>
            </a>
        </li>


        <li class="mt-2 w-[207px]">
            <a href="tel:+36 20 890 0702">
                <div class="py-2 px-4 text-left bg-sky-200 text-sky-700 rounded-t-md text-center">
                    <div class="mb-1 font-normal">
                        <i class="fa-light mr-1 fa-mobile-screen-button"></i> @lang('pages/contact.call_us')
                    </div>
                    +36 20 890 0702
                </div>
            </a>
        </li>

        <li class="w-[207px]">
            <a href="mailto:support@riel.hu">
                <div class="py-2 px-4 text-left bg-sky-300 text-sky-800 rounded-b-md text-center">
                    <div class="mb-1 font-normal">
                        <i class="fa-light mr-1 fa-envelope"></i> @lang('pages/contact.write_us')
                    </div>
                    support@riel.hu
                </div>
            </a>
        </li>


    </ul>
</div>


@push('scripts')
    <script>
        $('.support-sub').height($('.support-menu').height());
    </script>
@endpush
