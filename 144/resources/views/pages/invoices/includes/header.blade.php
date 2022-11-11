<div class="flex gap-4">
    <div class="basis-1/2">
        <x-card class="grid grid-cols-2">
            @php
                $company = \App\Models\Customer::find(1074);
            @endphp

            <div>{{ __('pages/invoices.seller') }}</div>
            <div></div>

            <div class="text-gray-500 font-thin">{{ __('form.name') }}:</div>
            <div class="font-semibold">{{ $company->Nev }}</div>

            <div class="text-gray-500 font-thin">{{ __('form.address') }}:</div>
            <div>{!! $company->getAddress()->withoutName()->getConcatenatedString() !!}</div>

            @if ($company->Kod)
                <div class="text-gray-500 font-thin">{{ __('pages/invoices.customer_id') }}:</div>
                <div>{{ $company->Kod }}</div>
            @endif

            @if ($company->Adoszam)
                <div class="text-gray-500 font-thin">{{ __('form.company_tax_number') }}:</div>
                <div>{{ $company->getFormattedTaxNumber() }}</div>
            @endif


        </x-card>

        <x-card class="grid grid-cols-2 mt-4">
            @if($invoiceNumber = $invoice->getNumber())
                <div class="text-gray-500 font-thin">@lang('pages/orders.id')</div>
                <div class="font-semibold">{{ $invoiceNumber }}</div>
            @endif

            <div class="text-gray-500 font-thin">{{ __('pages/orders.payment_method') }}</div>
            <div>{{ $invoice->getPayment() }}</div>

            <div class="text-gray-500 font-thin">{{ __('pages/invoices.fulfillment_date') }}</div>
            <div>{{ $invoice->getFulfillmentDate() }}</div>

            <div class="text-gray-500 font-thin">{{ __('pages/invoices.issue_date') }}</div>
            <div>{{ $invoice->getIssueDate() }}</div>

            <div class="text-gray-500 font-thin">{{ __('pages/invoices.payment_deadline') }}</div>
            <div>{{ $invoice->getPaymentDeadline() }}</div>

            @if($invoice->currency)
                <div class="text-gray-500 font-thin">{{ __('prices.currency') }}</div>
                <div>{{ $invoice->currency->Nev }}</div>
            @endif
        </x-card>
    </div>

    <div class="basis-1/2">
        <x-card class="grid grid-cols-2">
            <div>{{ __('pages/invoices.customer') }}</div>
            <div></div>

            <div class="text-gray-500 font-thin">{{ __('form.name') }}:</div>
            <div class="font-semibold">{{ $invoice->customer->Nev }}</div>

            <div class="text-gray-500 font-thin">{{ __('form.address') }}:</div>
            <div>{!! $invoice->getCustomerAddress()->withoutName()->getConcatenatedString() !!}</div>

            @if ($invoice->customer->Kod)
                <div class="text-gray-500 font-thin">{{ __('pages/invoices.customer_id') }}:</div>
                <div>{{ $invoice->customer->Kod }}</div>
            @endif

            @if ($invoice->customer->Adoszam)
                <div class="text-gray-500 font-thin">{{ __('form.company_tax_number') }}:</div>
                <div>{{ $invoice->customer->getFormattedTaxNumber() }}</div>
            @endif

            @if ($invoice->customerEmployee)
                <div class="text-gray-500 font-thin">{{ __('pages/invoices.client_administrator') }}:</div>
                <div>{{ $invoice->customerEmployee->Nev }}</div>
            @endif

            @if($invoice->customerPremise)
                <div class="text-gray-500 font-thin">{{ __('pages/account.customer_premise') }}</div>
                <div>{{ $invoice->customerPremise->getAddress() }}</div>
            @endif
        </x-card>

        @if ($invoice->SzamlaPdf)
            <div class="mt-4 flex justify-end">
                <a href="{{ $invoice->getPdfRoute() }}" class="btn-green-500 font-bold w-fit" target="_blank">
                    <i class="fal fa-download mr-2"></i>
                    {{ __('media.download') }}
                </a>
            </div>
        @endif
    </div>
</div>



