<table class="w-full table-fixed">
    <tbody>

    <tr>
        <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
            @lang('pages/services.worksheet_number')
        </td>
        <td class="py-2 pl-2 border-b border-gray-300 text-lg">{{ $serviceCertificate->getNumber()}}</td>
    </tr>
    <tr>
        <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
            @lang('pages/services.device')
        </td>
        <td class="py-2 pl-2 border-b border-gray-300">{{ $serviceCertificate->SzervizBerendezes }}</td>
    </tr>
    <tr>
        <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
            @lang('pages/services.serial_number')
        </td>
        <td class="py-2 pl-2 border-b border-gray-300">{{ $serviceCertificate->getSerialNumber() }}</td>
    </tr>
    <tr>
        <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
            @lang('pages/services.malfunction')
        </td>
        <td class="py-2 pl-2 border-b border-gray-300">{{ $serviceCertificate->EgyebHiba }}</td>
    </tr>
    <tr>
        <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
            @lang('pages/services.previous_service')
        </td>
        <td class="py-2 pl-2 border-b border-gray-300">
            @php $relatedCertificates = $serviceCertificate->getRelatedCertificates(); @endphp
            @if($relatedCertificates->count() > 0)
                @foreach($relatedCertificates as $relatedCertificate)
                    <a class="link inv"
                       href="{{ LUrl::route('service.show', ['id' => $relatedCertificate]) }}">{{ $relatedCertificate->getNumber() }}
                    </a>
                @endforeach
            @else
                @lang('pages/services.no_previous_patch')
            @endif
        </td>
    </tr>

    <tr>
        <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
            @lang('pages/services.accessories')
        </td>
        <td class="py-2 pl-2 border-b border-gray-300">
            @if($serviceCertificate->SzervizTartozekok)
                {{ $serviceCertificate->SzervizTartozekok }}
            @else
                @lang('pages/services.not_handed_over')
            @endif
        </td>
    </tr>

    @if($serviceCertificate->clerk)
        <tr>
            <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
                @lang('pages/services.administrator')
            </td>
            <td class="py-2 pl-2 border-b border-gray-300">{{ $serviceCertificate->clerk->Nev }}</td>
        </tr>
    @endif


    @if($serviceCertificateEvent)
        <tr>
            <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
                @lang('pages/services.service_status')
            </td>
            <td class="py-2 pl-2 border-b border-gray-300">{{ $serviceCertificateEvent->getEventType() }}</td>
        </tr>
        <tr>
            <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
                @lang('pages/services.service_date_time')
            </td>
            <td class="py-2 pl-2 border-b border-gray-300">{{ Fct::dateTime($serviceCertificateEvent->Datum) }}</td>
        </tr>
    @endif

    </tbody>
</table>
