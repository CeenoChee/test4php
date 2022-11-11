@if($downloadCategory->translation)
    <div class="my-6">
    <a class="text-inherit" href="{{  LUrl::route('download.categories.show', ['downloadCategorySlug' => $downloadCategory->translation->slug]) }}">
        <div class="text-center">
            @if($downloadCategory->media->count() > 0)
                <img src="{{$downloadCategory->media->first()->getFilesUrl() }}" class="mx-auto rounded-md h-[200px] w-[200px]" />
            @endif
        </div>
        <div class="font-bold text-2lg mt-4 text-center">
            {{ $downloadCategory->translation->name }}
        </div>
        <div class="text-center text-gray-300 font-bold my-2">
            {{ $downloadCategory->downloads->count() }} @lang('pages/downloads.software')
        </div>
        <div class="text-gray-400 text-center">
            {{$downloadCategory->translation->description}}
        </div>
    </a>
    </div>
@endif
