@php $user = app('User'); @endphp
@if(!$user->isVerified())

    <x-alert class="alert-warning text-center">
        @lang('pages/auth.email_not_confirmed', ['link' => route('auth.send.verification', ['locale' => app('Lang')->getLocale()])])
    </x-alert>

@elseif($user->isPending())

    <x-alert class="alert-warning text-center">
        @lang('pages/auth.profile_pending')
    </x-alert>

@elseif(!$user->isRielActive())

    <x-alert class="alert-warning text-center">
        @lang('pages/auth.profile_not_activated')
    </x-alert>

@endif
