@extends('emails.layout')

@section('content')
    <p>
        @lang('emails.dear_name', ['name' => $order->getName()])
    </p>

    <h2>Rendelésedet köszönettel megkaptuk az alábbiak szerint:</h2><br>

    <table class="mb-4">
        <tr>
            <td>@lang('pages/orders.id'):</td>
            <td class="pl-1">{{ $order->getNumber() }}</td>
        </tr>
        <tr>
            <td>@lang('form.name'):</td>
            <td class="pl-1">{{ $order->getName() }}</td>
        </tr>
        <tr>
            <td>@lang('form.phone_number'):</td>
            <td class="pl-1">{{ $order->getPhone() }}</td>
        </tr>
        <tr>
            <td>@lang('form.mobile'):</td>
            <td class="pl-1">{{ $order->getMobile() }}</td>
        </tr>
        <tr>
            <td>@lang('form.email'):</td>
            <td class="pl-1">{{ $order->getEmail() }}</td>
        </tr>
        <tr>
            <td>@lang('pages/orders.payment_method'):</td>
            <td class="pl-1">{{ $order->getPayment() }}</td>
        </tr>
        <tr>
            <td colspan="2" class="py-1">
                <strong>Számlázási adatok</strong>
            </td>
        </tr>
        <tr>
            <td>@lang('form.address'):</td>
            <td class="pl-1">{!! $order->getBillingAddress()->toHtml() !!}</td>
        </tr>
        <tr>
            <td colspan="2" class="py-1">
                <strong>Szállítási adatok</strong>
            </td>
        </tr>
        <tr>
            <td>@lang('pages/orders.takeover'):</td>
            <td class="pl-1">{{ $order->getShipmentCost() }}</td>
        </tr>
        <tr>
            <td>@lang('form.address'):</td>
            <td class="pl-1">{!! $order->getDeliveryAddress()->toHtml() !!}</td>
        </tr>
        @if($order->getShippingPhone())
            <tr>
                <td>@lang('form.phone'):</td>
                <td class="pl-1">{{ $order->getShippingPhone() }}</td>
            </tr>
        @endif
        @if($order->getShippingEmail())
            <tr>
                <td>@lang('form.email'):</td>
                <td class="pl-1">{{ $order->getShippingEmail() }}</td>
            </tr>
        @endif
        @if($order->getShippingComment())
            <tr>
                <td>@lang('pages/orders.comment_to_courier'):</td>
                <td class="pl-1">{{ $order->getShippingComment() }}</td>
            </tr>
        @endif
        <tr>
            <td>@lang('pages/orders.part_delivery'):</td>
            <td class="pl-1">@if($order->getShipping()->is(\App\Libs\Enums\Shipping::ITEM_PART)) @lang('global.yes') @else @lang('global.no') @endif</td>
        </tr>
        @if(!$order->getShipmentCost()->is(\App\Libs\Enums\ShipmentCost::CUSTOMER))
            <tr>
                <td>@lang('pages/orders.return'):</td>
                <td class="pl-1">@if($order->getReturnGoods()) @lang('global.yes') @else @lang('global.no') @endif</td>
            </tr>
        @endif
        <tr>
            <td style="vertical-align: baseline;">@lang('pages/orders.comment_to_order'):</td>
            <td class="pl-1">
                @if(isset($editable))
                    {!! Form::textarea('megjegyzes', $order->getComment(), ['class' => 'form-control', 'rows' => 3]) !!}
                @elseif(!is_null($order->getComment()) && $order->getComment() !== "")
                    {{ $order->getComment() }}
                @else
                    <i>@lang('pages/orders.no_comments').</i>
                @endif
            </td>
        </tr>
    </table>
    <table class="table fullwidth small-font">
        <thead>
        <tr class="border-bottom">
            <th style="width: 15%">@lang('pages/products.model_no')</th>
            <th style="width: 20%">@lang('pages/products.product')</th>
            <th style="width: 15%">@lang('pages/orders.delivery_time_2')</th>
            <th style="width: 15%">@lang('pages/orders.quantity')</th>
            <th style="width: 15%">@lang('prices.unit_price')</th>
            <th style="width: 20%">@lang('pages/products.value')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->getItems() as $orderItem)
            @php
                $product = $orderItem->getProduct();
            @endphp
            <tr class="bordered">
                <td><a href="{{ LUrl::routeProduct($product, true) }}">{{ $product->Kod }}</a></td>
                <td>{{ $product->trans->Nev }}</td>
                <td>{{ $orderItem->getDeliveryTime()->getDate() }}</td>
                <td>{{ $orderItem->getQty() }} @lang('pages/orders.piece')</td>
                <td>{{ Fct::price($orderItem->getCustomerPrice()) }}</td>
                <td>{{ Fct::price($orderItem->getRowTotal()) }}</td>
            </tr>
        @endforeach
        <tr class="border-top">
            <td colspan="5"><b>@lang('pages/products.products')</b></td>
            <td>{{ Fct::price($order->getItemAmount()) }} + @lang('prices.vat')</td>
        </tr>
        <tr>
            <td colspan="5">@lang('prices.shipping_price')</td>
            <td>{{ Fct::price($order->getShipmentAmount()) }} + @lang('prices.vat')</td>
        </tr>
        <tr>
            <td colspan="5"><b>@lang('pages/orders.summary_total')</b></td>
            <td><b>{{ Fct::price($order->getTotal()) }} + @lang('prices.vat')</b></td>
        </tr>
        </tbody>
    </table>

    <p><b>Rendelésed feldolgozása folyamatban van, állapotát egyszerűen és kényelmesen nyomon követheted felhasználói
            fiókod Rendelések menüpontjában.</b></p>

    <p>Abban az esetben, ha részszállítást igényeltél, csomagod több részletben fog megérkezni a termékek mellett
        található szállítási határidők szerint. Egyéb esetben a legkésőbbi szállítási határidőt kérjük figyelembe
        venni.</p>

    <p>A RIEL Online Áruházban feltüntetett árak nettó árak, az általános forgalmi adót (ÁFA-t) nem tartalmazzák.</p>

    <p>Fenti rendelésre érvényes Általános Szerződési Feltételeink megtekintéséhez <a
                href="{{ LUrl::route('terms') }}">kattints ide</a>.</p>

    <p>Kérdés esetén kollégáink készséggel állnak rendelkezésedre a <a
                href="mailto: rendeles@riel.hu">rendeles@riel.hu</a> e-mail címen vagy a
        <b>+36 (1) 236 8090</b> telefonszámon.</p>

    <p>Köszönjük megtisztelő bizalmadat!</p>
@endsection
