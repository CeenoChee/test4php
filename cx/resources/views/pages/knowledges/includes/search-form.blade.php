<div class="text-3xl mb-6 text-center mt-4">
    @lang('global.how_can_we_help')
</div>

<div class="text-gray-500 text-center mb-2 w-1/2 mx-auto">
    A tudástár bejegyzéseink között megtalálod az általunk forgalmazott eszközökhöz készült útmutatóinkat, telepítői leírásainkat. A kereső segítségével könnyedén megtalálhatod a kívánt kategóriákat vagy leírásokat.
</div>

<div class="mx-auto w-1/2">
    <form class="relative" method="get" action="{{ LUrl::route('knowledge.results') }}">
        <div class="flex">
            <input type="text" class="!pr-12" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif"
                   placeholder="@lang('global.placeholder.search')" required/>
        </div>

        <button class="absolute top-0 right-0 w-12 h-10 text-lg">
            <i class="fal fa-search"></i>
        </button>
    </form>
</div>
