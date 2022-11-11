<div class="my-6">
    <a class="text-inherit" href="{{ LUrl::route('knowledge.category', ['slug' => $category->translation->slug]) }}">
        <div class="text-center">
            @if($category->media->first())
                <img src="{{$category->media->first()->getFilesUrl() }}" class="mx-auto rounded-md h-[200px]" />
            @endif
        </div>
        <div class="font-bold text-2lg mt-4 text-center">
            {{ $category->translation->name}}
        </div>
        <div class="text-center text-gray-300 font-bold my-2">
            @if($category->knowledges->count() > 0)
                {{$category->knowledges->count()}}  @lang('pages/knowledge.article')
            @elseif($category->children->count() > 0)
                {{$category->children->count()}}  @lang('pages/knowledge.category')
            @endif
        </div>
        <div class="text-gray-400 text-center">
            {{$category->translation->brief}}
        </div>
    </a>
</div>
