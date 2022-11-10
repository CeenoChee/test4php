@extends('layouts.with-left-sidebar')

@section('head')
    <link href="{{ mix('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/services.repairs')
@endsection

@section('content_title')
    @lang('pages/services.repairs')
@endsection


@section('breadcrumb')
    {{ Breadcrumbs::render('services') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection


@section('right-content')

    <x-card>
        <div class="overflow-x-auto p-4">
            <table class="w-full py-1" id="services-table">
                <thead class="bg-gray-100">
                <tr class="bg-neutral-200">
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/services.repair')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/products.product')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/orders.status')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($serviceCertificates as $serviceCertificate)
                    @php $eventType = $serviceCertificate->getEventType(); @endphp
                    <tr>
                        <td class="px-6 py-4 text-sm text-center text-gray-500">
                            <div>

                                @if($eventType->is(\App\Libs\Enums\EventType::EQUIPMENT_FIXED) || $eventType->is(\App\Libs\Enums\EventType::CUSTOMER_RECEIVED))
                                    <i class="fal fa-check text-green-500 w-8 text-2lg"></i>
                                @else
                                    <i class="fal fa-hourglass-half text-yellow-500 w-8 text-2lg"></i>
                                @endif

                                <span>{{ $serviceCertificate->getNumber() }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="mb-2">
                                <i class="fal fa-tag w-6 text-cyan-500"></i>
                                {{ $serviceCertificate->SzervizBerendezes }}
                            </div>
                            <div class="mb-2">
                                <i class="fal fa-calendar w-6 text-cyan-600"></i>
                                {{ Fct::date($serviceCertificate->getWorkCreateDate()) }}
                            </div>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">

                            <div class="mb-2">
                                <i class="fal fa-shopping-bag w-6 text-riel-light"></i>
                                @if($serviceCertificate->isWarranty())
                                    @lang('pages/services.warranty_alis')
                                @else
                                    @if($serviceCertificate->visibleItems())
                                        @php $netAmount = $serviceCertificate->getNetAmount(); @endphp
                                        @if($netAmount->getTotal() > 0)
                                            {{ ($serviceCertificate->getNetAmount()) }} <span
                                                class="text-2xs"
                                            >+ @lang('prices.vat')</span>
                                        @else
                                            @lang('pages/services.free_of_charge')
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="font-semibold">
                                {{ $eventType }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-center text-gray-500">
                            <div>
                                <a class="btn-outline"
                                   href="{{ LUrl::route('service.show', ['id' => $serviceCertificate->SzervizBiz_ID]) }}"
                                >@lang('global.view')
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
@endsection


@push('scripts')
    <script>
    $(document).ready(function () {
        $('#services-table').DataTable({
            language: {
                url: '/assets/lang/datatable/hu.json',
            },
            columnDefs: [{
                targets: 3,
                orderable: false,
            }],
            order: [[0, 'desc']],
        });
    });
    </script>
@endpush

