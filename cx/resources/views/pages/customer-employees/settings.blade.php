@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/account.settings')
@endsection

@section('content_title')
    @lang('pages/account.settings')
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('permissions.settings', $userInfo->getUser()) }}
@endsection

@section('right-content')

    {!! Form::open(['route' => ['employee.settings.save', 'locale' => app('Lang')->getLocale(), 'userId' => $userInfo->getUserId()]]) !!}

    <x-card>

        <div class="text-riel-light mb-4 font-bold">
            @lang('pages/account.personal_data')
        </div>

        <label>@lang('form.full_name')</label>
        <input class="form-control" disabled="disabled" type="text" value="{{ $userInfo->getName() }}">

        <label>@lang('form.email')</label>
        <input class="form-control" disabled="disabled" type="text" value="{{ $userInfo->getEmail() }}">

        <label class="required">@lang('form.position')</label>
        {!! Form::text('position',  $userInfo->getPosition()) !!}
        <x-input-error :field="'position'"/>

        <div class="flex gap-6">
            <div class="basis-1/2">
                <label>@lang('form.phone_number')</label>
                {!! Form::text('telephone',  $userInfo->getPhone()) !!}
            </div>

            <div class="basis-1/2">
                <label>@lang('form.mobile')</label>
                {!! Form::text('mobile',  $userInfo->getMobile()) !!}
            </div>
        </div>


        <label>@lang('form.fax')</label>
        {!! Form::text('fax',  $userInfo->getFax()) !!}

    </x-card>


    <x-card class="my-8">

        <div class="text-riel-light mb-4 font-bold">
            @lang('pages/account.permissions')
        </div>

        @include('pages.customer-employees.includes.permissions', ['permissions' => $permissions, 'isMySettings' => $isMySettings])
    </x-card>


    <div>
        <button type="submit" class="btn mx-auto my-4">
            <i class="fas fa-save mr-1"></i> @lang('form.save')
        </button>

    </div>

    @if(!$isMySettings && !$userInfo->isRielActive())
        @php $invitationValidity = $userInfo->getInvitationValidity() @endphp
        <button type="submit" class="btn-outline mx-auto my-4" name="resend_invitation">
            <i class="fas fa-envelope mr-1"></i> @lang('pages/account.resend_invitation')
        </button>


        @if($invitationValidity)
            <div>
                <a href="{{ route('employee.deleteInvitation', [$userInfo->getUser()]) }}"
                   class="btn-outline !text-red-700 !border-red-700 w-48 mx-auto my-4"
                   title="@lang('pages/account.delete_invitation')">
                    <i class="fas fa-trash-alt mr-1"></i> {{ __('pages/account.delete_invitation') }}
                </a>
            </div>
        @endif


        <div class="text-center text-xs text-gray-400">
            @lang('pages/account.status'):
            @if($userInfo->isRielActive())
                @lang('pages/account.active')
            @else
                @lang('pages/account.inactive')
            @endif

            @if($invitationValidity)
                <div>@lang('pages/account.date_of_invitation'): {{ $userInfo->getUser()->invited_at }}</div>
                <div>@lang('pages/account.validity'): {{ $invitationValidity }}</div>
            @endif
        </div>

    @endif

    {!! Form::close() !!}

@endsection

