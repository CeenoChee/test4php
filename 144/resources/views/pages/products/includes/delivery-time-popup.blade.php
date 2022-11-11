<div class="close"><i class="fal fa-times"></i></div>
<div class="title">@lang('stocks.stock_and_shipping')</div>

<table>
    <tr>
        <td>@lang('pages/orders.quantity'):</td>

        <td>{{ $qty.' ' }} @if($product->mennyisegEgyseg) {{ trim($product->unit->Nev) }}@endif</td>

        <td></td>
    </tr>

    <tr>
        <td>@lang('stocks.warehouse')</td>
        <td>@lang('pages/orders.quantity')</td>
        <td>@lang('pages/orders.delivery_time')</td>
    </tr>

    @foreach($rows as $row)
        @php $deliveryTime = $row['SzallHatarido']; @endphp
        <tr>
            <td>
                <i class="fas fa-circle status-{{ $row['color'] }}"></i>
                {{ $row['Nev'] }}
            </td>
            <td>{{ $row['Keszlet'].' '}} @if($product->mennyisegEgyseg) {{ trim($product->unit->Nev) }}@endif</td>
            <td>
                @if($deliveryTime->isEmpty())
                    @lang('global.ask_about')
                @elseif($deliveryTime->isToday())
                    <span>@lang('dates.today') @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                @elseif($deliveryTime->isNextBusinessDay())
                    <span>@lang('dates.next_business_day') @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                @else
                    <span>{{ $deliveryTime->getDate() }} @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>
@if($product->Kifuto)
    <div>
        <span>@lang('stocks.while_stocks_last')</span>
    </div>
@endif

@if($maxOrder !== null)
    <div>
        <span>@lang('stocks.max_order_item', ['maxOrder' => $maxOrder, 'unit' => ($product->unit ? $product->unit->Nev : '')])</span>
    </div>
@endif
