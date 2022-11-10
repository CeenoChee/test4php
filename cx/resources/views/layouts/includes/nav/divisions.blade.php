<div class="group inline-block">
    <li class="inline-block uppercase p-4 outline-none flex items-center min-w-32">
        <span class="pr-1 font-bold flex-1">
            <a href="{{LUrl::route('divisions')}}" class="text-white hover:text-sky-300">@lang('pages/divisions.title')</a>
        </span>
        <span>
          @include('layouts.includes.nav.svg.arrow-y-svg')
        </span>
    </li>
    <ul class="z-30 bg-riel-dark rounded-bl-md transform scale-0 group-hover:scale-100
                    absolute transition duration-150 ease-in-out origin-top h-[150px] py-4 pl-4">

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="https://www.beu.riel.hu"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1">
                    <i class="fal mr-1 fa-shield-check w-4 text-center"></i>
                   @lang('pages/divisions.security_inspections')
                </span>
            </a>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="https://www.im.riel.hu/"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1">
                    <i class="fal mr-1 fa-user-helmet-safety w-4 text-center"></i>
                  @lang('pages/divisions.industrial_solutions')
                </span>
            </a>
        </li>

        <li class="rounded-l-full hover:bg-riel-dark pr-4">
            <a href="https://www.pro.riel.hu/"
               class="text-white w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2">

                <span class="pr-1 flex-1">
                    <i class="fal mr-1 fa-camera-cctv w-4 text-center"></i>
                  @lang('pages/divisions.professional_safety_solutions')
                </span>
            </a>
        </li>

    </ul>
</div>
