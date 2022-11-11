<div class="grid lg:grid-rows-2 lg:grid-flow-col gap-4">

    <x-card class="">

        <div class="text-riel-light mb-4 font-bold">
            @lang('form.personal_data')
        </div>

        <div class="grid grid-cols-2">
            @if($orderNumber = $order->getNumber())
                <div class="text-gray-500 font-thin">@lang('pages/orders.id'):</div>
                <div class="font-semibold">{{ $orderNumber }}</div>
            @endif

            <div class="text-gray-500 font-thin">@lang('form.name'):</div>
            <div>{{ $order->getName() }}</div>

            <div class="text-gray-500 font-thin">@lang('form.email'):</div>
            <div>{{ $order->getEmail() }}</div>

            <div class="text-gray-500 font-thin">@lang('form.phone_number'):</div>
            <div>{{ $order->getPhone() }}</div>

            <div class="text-gray-500 font-thin">@lang('form.mobile'):</div>
            <div>{{ $order->getMobile() }}</div>
        </div>
    </x-card>


    <x-card>

        <div class="text-riel-light mb-4 font-bold">
            @lang('pages/orders.shipping')
        </div>

        <div class="grid grid-cols-2">
            <div class="text-gray-500 font-thin">@lang('pages/orders.part_delivery'):</div>
            <div>
                @if($order->getShipping()->is(\App\Libs\Enums\Shipping::ITEM_PART))
                    @lang('global.yes')
                @else
                    @lang('global.no')
                @endif
            </div>

            @if(!$order->getShipmentCost()->is(\App\Libs\Enums\ShipmentCost::CUSTOMER))
                <div class="text-gray-500 font-thin">@lang('pages/orders.return'):</div>
                <div>
                    @if($order->getReturnGoods())
                        @lang('global.yes')
                    @else
                        @lang('global.no')
                    @endif
                </div>
            @endif

            <div class="text-gray-500 font-thin">@lang('pages/orders.comment_to_order'):</div>
            <div>
                @if(isset($editable))
                    {!! Form::textarea('megjegyzes', $order->getComment(), ['class' => 'form-control mt-1', 'rows' => 3, 'placeholder' => 'pl. Egy csomagba kérném a rendelésemet']) !!}
                @elseif(!is_null($order->getComment()) && $order->getComment() !== "")
                    {{ $order->getComment() }}
                @else
                    <i>@lang('pages/orders.no_comments').</i>
                @endif
            </div>
        </div>
    </x-card>


    <x-card class="row-span-2">

        <div class="text-riel-light mb-4 font-bold">
           @lang('pages/orders.takeover_and_addresses')
        </div>

        <div class="grid grid-cols-2">

            <div class="text-gray-500 font-thin">@lang('pages/orders.takeover'):</div>
            <div>{{ $order->getShipmentCost() }}</div>

            <div class="text-gray-500 font-thin">@lang('pages/orders.payment_method'):</div>
            <div>{{ $order->getPayment() }}</div>

            <div class="my-2 text-gray-500 font-thin">@lang('pages/orders.billing_address'):</div>
            <div class="my-2">{!! $order->getBillingAddress()->getFormattedAddress() !!}</div>

            <div class="my-2 text-gray-500 font-thin">@lang('pages/orders.shipping_address'):</div>
            <div class="my-2">{!! $order->getDeliveryAddress()->getFormattedAddress() !!}</div>

            @if($order->getShippingPhone())
                <div class="text-gray-500 font-thin">@lang('form.phone'):</div>
                <div>{{ $order->getShippingPhone() }}</div>
            @endif

            @if($order->getShippingEmail())
                <div class="text-gray-500 font-thin">@lang('form.email'):</div>
                <div>{{ $order->getShippingEmail() }}</div>
            @endif

            @if($order->getShippingComment())
                <div class="text-gray-500 font-thin">@lang('pages/orders.comment_to_courier'):</div>
                <div>{{ $order->getShippingComment() }}</div>
            @endif
        </div>
    </x-card>
</div>

