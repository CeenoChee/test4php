@php
    $user = app('User');
@endphp

<div class="leading-normal">
    <div class="whitespace-nowrap flex">
        <div class="text-right pr-4">
            <i class="fal fa-user-circle text-xl"></i>
        </div>
        <div class="w-40">
            <div class="text-[1rem] font-semibold truncate">{{ $user->getName() }}</div>
            <div class="text-xs text-gray-500 truncate">{{ $user->getEmail() }}</div>
            <div
                class=" mt-1 leading-none truncate">
                <div
                    class="font-bold text-riel-dark text-2xs rounded-md px-2 py-2  max-w-[10rem] w-fit max-w-fit border border-riel-dark truncate">
                    {{ $user->getCompanyName() }}
                </div>
            </div>
        </div>
    </div>

    <div class="account-item">
        @if($user->isRielActive())
            @if(isset($header) && $user->isReseller())
                <div class="mt-2 mb-4 flex relative right-[10px]">

                    <label class="switch">
                        <input type="checkbox" @if($user->installerPrice()) checked="checked"
                               @endif name="installer_price">
                        <span class="switch-slider scale-75"></span>
                    </label>

                    <div class="text-xs my-auto">@lang('prices.installer_price')</div>
                </div>
            @endif
        @endif

        <a href="{{ LUrl::route('account.index') }}"
           class="text-inherit mt-2 flex @if(LUrl::route('account.index') == '/'.request()->path()) text-riel-light font-bold @endif">
            <div class="text-center w-[40px]">
                <i class="fal fa-user-cog"></i>
            </div>
            <div class="">
                @lang('pages/account.account')
            </div>
        </a>

        @if($user->isRielActive())
            <a href="{{ LUrl::route('account.addresses') }}"
               class="text-inherit mt-2 flex @if(LUrl::route('account.addresses') == '/'.request()->path()) text-riel-light font-bold @endif">
                <div class="text-center w-[40px]">
                    <i class="fal fa-building"></i>
                </div>
                <div class="">
                    @lang('pages/account.addresses')
                </div>
            </a>


            @if($user->hasOrderPermission())
                <a href="{{ LUrl::route('account.my.orders') }}"
                   class="text-inherit mt-2 flex @if(LUrl::route('account.my.orders') == '/'.request()->path()) text-riel-light font-bold @endif">
                    <div class="text-center w-[40px]">
                        <i class="fal fa-tasks"></i>
                    </div>
                    <div class="">
                        @lang('pages/orders.orders')
                    </div>
                </a>
            @endif

            <a href="{{ LUrl::route('export.index') }}"
               class="text-inherit mt-2 flex @if(LUrl::route('export.index') == '/'.request()->path()) text-riel-light font-bold @endif">
                <div class="text-center w-[40px]">
                    <i class="fal fa-table"></i>
                </div>
                <div class="">
                    @lang('pages/export.price_list')
                </div>
            </a>


            @if($user->isRiel() && $user->hasServicePermission())
                <a href="{{ LUrl::route('service.list') }}"
                   class="text-inherit mt-2 flex @if(LUrl::route('service.list') == '/'.request()->path()) text-riel-light font-bold @endif">
                    <div class="text-center w-[40px]">
                        <i class="fal fa-tools"></i>
                    </div>
                    <div class="">
                        @lang('pages/services.repair')
                    </div>
                </a>
            @endif

            @if($user->hasFinancePermission())
                <a href="{{ LUrl::route('invoices.index') }}"
                   class="text-inherit mt-2 flex @if(LUrl::route('invoices.index') == '/'.request()->path()) text-riel-light font-bold @endif">
                    <div class="text-center w-[40px]">
                        <i class="fal fa-file-alt"></i>
                    </div>
                    <div class="">
                        @lang('pages/invoices.invoices')
                    </div>
                </a>

            @endif

            <a href="{{ LUrl::route('settings.index') }}"
               class="text-inherit mt-2 flex @if(LUrl::route('settings.index') == '/'.request()->path()) text-riel-light font-bold @endif">
                <div class="text-center w-[40px]">
                    <i class="fal fa-cogs "></i>
                </div>
                <div class="">
                    @lang('pages/account.settings')
                </div>
            </a>

            @if($user->isLoggedIn() && $user->getCustomerId())

                <a href="{{ LUrl::route('employees.index') }}"
                   class="text-inherit mt-2 flex @if(LUrl::route('employees.index') == '/'.request()->path()) text-riel-light font-bold @endif">
                    <div class="text-center w-[40px]">
                        <i class="fal fa-users"></i>
                    </div>
                    <div class="">
                        @lang('pages/account.permissions')
                    </div>
                </a>

            @endif
        @endif


    </div>

    <div class="flex mt-4">
        <div class="w-[40px]"></div>
        <div class="">
            <a href="{{ LUrl::route('logout') }}" class="!text-riel-light">@lang('pages/auth.logout')</a>
        </div>
    </div>
</div>
