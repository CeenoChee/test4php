<div class="w-full h-[300px] flex items-center justify-center bg-gradient-to-r from-cyan-500 to-blue-500">

    <div class="w-1/2">
        <div class="text-3xl mb-6 text-center mt-4 text-white">
            @lang('global.how_can_we_help')
        </div>

        <div class="mx-auto">
            <form class="relative" method="get" action="{{ LUrl::route('support.results') }}">
                <div class="flex">
                    <input type="text" class="!pr-12" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif"
                           placeholder="@lang('global.placeholder.search')" required/>
                </div>

                <button class="absolute top-0 right-0 w-12 h-10 text-lg">
                    <i class="fal fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>
