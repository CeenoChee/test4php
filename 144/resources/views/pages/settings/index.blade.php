@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/account.settings')
@endsection

@section('content_title')
    @lang('pages/account.settings')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('settings') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <div class="grid grid-cols-2 gap-4">
        <x-card>
            <h2 class="text-riel-light mb-4 font-bold">
              @lang('pages/newsletters.newsletter')
            </h2>

            <form method="POST" action="{{ route('newsletter.update', ['locale' => app('Lang')->getLocale()]) }}" id="settings-form">
                @csrf
                @foreach($newsletters as $newsletter)
                    <div class="mb-4">
                        <label class="switch mr-1">
                            <input type="checkbox"
                                   name="newsletters[]"
                                   value="{{ $newsletter->id }}"
                                   @if(in_array($newsletter->name, $checked)) checked="checked" @endif>
                            <span class="switch-slider"></span>
                        </label>
                        <span>{{ $newsletter->label }}</span>
                    </div>
                @endforeach
            </form>

        </x-card>

        @if($user->isReseller())
            <x-card>

                <h2 class="text-riel-light mb-4 font-bold">
                   @lang('prices.prices')
                </h2>

                <div class="d-flex align-items-center mb-1">
                    <label class="switch mr-1">
                        <input type="checkbox"
                               @if($user->installerPrice()) checked="checked" @endif
                               name="installer_price"
                               data-url="{{ route('installer.price.save', ['locale' => app('Lang')->getLocale()]) }}">
                        <span class="switch-slider"></span>
                    </label>
                    <span>@lang('prices.installer_price')</span>
                </div>
            </x-card>
        @endif
    </div>




@endsection

