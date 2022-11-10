@extends('layouts.app')

@section('title')
    @lang('pages/account.profile')
@endsection

@section('content_title')
    @lang('pages/account.profile')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('profile') }}
@endsection

@section('content')

            <h2 class="maintitle">@lang('pages/newsletters.newsletter')</h2>
            <form method="POST" action="{{ route('newsletter.subscriptions.update', ['id' => $id, 'hash' => $hash]) }}">
                @csrf
                <fieldset>
                    <legend>@lang('pages/newsletters.subscriptions')</legend>
                    @foreach($newsletters as $newsletter)
                        <div class="d-flex align-items-center mb-1">
                            <label class="switch mr-1">
                                <input type="checkbox"
                                    name="newsletters[]"
                                    value="{{ $newsletter->id }}"
                                    @if(in_array($newsletter->name, $checked)) checked="checked" @endif
                                >
                                <span class="switch-slider"></span>
                            </label>
                            <span>{{ $newsletter->label }}</span>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary center-block submit">@lang('form.save')</button>
                </fieldset>
            </form>
@endsection
