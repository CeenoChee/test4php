@php
    $hasMedia = !! $banner->trans->getImageMedia();
@endphp

<div class="flex flex-row">

    <div class="md:basis-3/4 lg:basis-2/4 shadow-md rounded-md w-full bg-white h-fit self-center text-center text-white banner opacity-0 " style="background-color:rgba(0, 0, 0, 0.05);">

        @if ($hasMedia)
            <img class="md:h-[106px] mx-auto" src="{{ $banner->trans->getLogoMedia()->getFilesUrl() }}">
        @endif

        <div class="pt-2 px-14">
            <div
                class="text-xl font-semibold mb-3 leading-8">
                {{ $banner->trans->name }}
            </div>
            <div class="font-semibold drop-shadow-md">
                {{ $banner->trans->description }}
            </div>
            <div class="mt-4 mb-8 h-10">
                <a class="btn max-w-10 mx-auto bg-gradient-to-r from-riel-dark to-riel-light font-semibold text-lg hover:!from-riel-dark" href="{{ $banner->trans->link }}">@lang('pages/home.more')</a>
            </div>
        </div>
    </div>

    <div class="hidden md:block ml-auto">
        @if ($hasMedia)
            <img class="product-image h-[416px] lazyload" data-src="{{ $banner->trans->getImageMedia()->getFilesUrl() }}">
        @endif
    </div>

</div>
