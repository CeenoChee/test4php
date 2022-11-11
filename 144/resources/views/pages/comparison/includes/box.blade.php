<div>
    <div id="compare-box" @if($active) class="active fixed bottom-1/2 right-0 h-16" @else class="hidden" @endif>
        <div class="item-list block">
            <div id="compare-box-content" class="border border-neutral-200 h-[80px]">
                {!! $content !!}
            </div>
            <a class="bg-white text-gray-500 hover:text-riel-light border-neutral-200 border p-2 text-center" data-label="@lang('pages/comparison.compare')" href="{{ LUrl::route('comparison.index') }}">
                <i class="fal fa-scale-unbalanced"></i>
            </a>
            <button class="bg-white text-gray-500 hover:text-riel-light border-neutral-200 border p-2" data-url="{{ route('comparison.clear', ['locale' => app('Lang')->getLocale()]) }}"
                    data-label="@lang('pages/comparison.delete_all_item')">
                <i class="fal fa-times"></i>
            </button>
        </div>
    </div>
</div>


<style>
    #compare-box-content img{
        max-height: 100%;
        max-width: 3rem;
        min-width: 3rem;
        width: 3rem;
        margin-top: 5px;
    }
</style>
