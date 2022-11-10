@foreach($videos as $video)
    <div class="bg-white shadow-2xl rounded-md">
        <a class="text-inherit" target="_blank" href="{{$video->url}}">
            <div>
                <img src="{{ $video->image }}" class="rounded-t-md mx-auto">
            </div>

            <div class="px-4 pb-4">
                <h4 class="font-bold text-xs my-3 h-8 overflow-y-hidden">{{ $video->title }}</h4>

                <div class="text-xs">
                    <span class="mr-4">
                        <i class="fal fa-eye"></i>
                        {{ $video->views }}
                    </span>

                    @if ($video->likes > 0)
                        <span class="mr-4">
                        <i class="fal fa-thumbs-up"></i> {{ $video->likes }}
                    </span>
                    @endif

                    <span>
                    <i class="fal fa-calendar"></i> {{ Fct::timeElapsedString($video->published_at) }}
                </span>
                </div>
            </div>

        </a>
    </div>
@endforeach


