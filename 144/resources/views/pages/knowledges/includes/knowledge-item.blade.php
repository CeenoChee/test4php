@if($knowledge->isActive() && $knowledge->translation)
    <div class="shadow-2xl text-lg bg-white md:flex my-4 border border-neutral-200 rounded-md">

        <div class="text-center mr-1 py-2 px-2 bg-blue-100 hidden md:block leading-none">

            <div class="text-sm text-riel-dark">
                {{ $knowledge->views }}
            </div>

            <div class="text-2xs text-gray-500 mb-2">
                @lang('pages/knowledge.views')
            </div>


            <div class="text-2xs text-gray-400">
                ~ {{ calculateReadingTime($knowledge->translation->body_stripped) }}
            </div>
        </div>

        <div class="p-4 pb-2 leading-none">
            <a class="text-inherit" href="{{ LUrl::route('knowledge.article', ['categorySlug' => $category->translation->slug, 'slug' => $knowledge->translation->slug]) }}">
                {{$knowledge->translation->title}}
            </a>

            <div class="text-gray-400 text-xs mt-2">
                {{mb_substr(str_replace('&nbsp;', ' ', $knowledge->translation->brief), 0, 140)}}
            </div>

        </div>


    </div>
@endif
