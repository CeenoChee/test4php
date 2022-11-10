<button class="compare-all-btn leading-none right-0 top-[180px] p-4 rounded-l-md bg-gradient-to-r from-riel-light to-riel-dark text-white  @if($active) fixed @else hidden @endif">
    <div class="bg-white text-riel-light border-2 border-riel-light rounded-full absolute text-2xs w-[20px] h-[20px] top-[40px] left-[-5px] font-bold leading-normal" id="compare-count">
        {{$count}}
    </div>

    <i class="fa fa-arrow-right-arrow-left text-lg"></i>

    <div class="compare-text font-bold ml-1">@lang('pages/comparison.compare')</div>
</button>

<div id="compare-modal" class="modal text-sm">
    <h2 class="border-b border-neutral-200 pb-2 mb-4 text-gray-600 text-lg font-thin">@lang('pages/comparison.compare')</h2>
    <div class="compare-content overflow-x-scroll">
        {!! $content !!}
    </div>
    <hr class="my-4">
    <div class="grid md:grid-cols-2 gap-8">
        <button class="btn-outline w-full md:w-fit" id="compare-clear" data-url="{{ route('comparison.clear', ['locale' => app('Lang')->getLocale()]) }}">
            @lang('global.delete_all')
        </button>

        <a href="{{LUrl::route('comparison.index')}}" class="btn w-full md:w-fit md:ml-auto">@lang('pages/comparison.compare')</a>
    </div>
</div>
