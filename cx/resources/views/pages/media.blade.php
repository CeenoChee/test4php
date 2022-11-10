@extends('layouts.app')

@section('title')
    @lang('pages/media.file') - {{$filename}}
@endsection

@section('content_title')
    @lang('pages/media.download')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('media', $filename) }}
@endsection

@section('content')
        @if(request('error'))
            <x-alert class="alert-danger text-center">
                @if(request('error') == '404')
                    @lang('pages/media.file_does_not_exist')
                @elseif(request('error') == 'download-limit')
                    @lang('pages/media.reached_download_limit')
                @elseif(request('error') =='too-early')
                    @lang('pages/media.too_early_access') @lang('pages/media.try_later')
                @elseif(request('error') =='expired')
                    @lang('pages/media.expired')
                @elseif(request('error') =='forbidden')
                    @lang('pages/media.forbidden')
                @elseif(request('error') =='password')
                    @lang('pages/media.incorrect_password')
                @else
                    @lang('pages/media.error_occurred')
                @endif
            </x-alert>
        @endif

        <div class="font-semibold text-center ">
            {{$filename}}
        </div>

        @if(request('link'))
            <meta http-equiv="refresh" content="0;url=/media/{{$filename}}">

            <a href="/media/{{$filename}}" class="btn mt-4 mx-auto">@lang('pages/media.download_file')</a>
        @endif

        @if(request('protected') || (request('error') && request('error') =='password'))
            <h3 class="text-center text-lg mt-4">@lang('pages/media.password_protected')</h3>

            <form action="{{env('FILES_APP_URL')}}/media/{{$filename}}" method="POST" class="mx-auto w-1/2 mt-4">
                <input type="password" placeholder="Jelszó" name="password" class="form-control media-password"
                       required/>
                <input type="hidden" name="user_id" value="{{Auth::id()}}"/>
                <input type="hidden" name="token" value="{{Auth::check() ? Auth::user()->token : null}}"/>
                <button class="btn mt-4 mx-auto">@lang('pages/media.download')</button>
            @csrf
            </form>
        @endif

@endsection

@push('scripts')
    <script>
        $('.download-btn').click(function (e) {
            e.preventDefault()

            if ($('.media-password').val() !== "") {
                $('.media-password-panel').html("@lang('pages/media.download_soon')");
            }
        });
    </script>
@endpush
