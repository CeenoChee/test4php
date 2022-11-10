<?php

namespace App\Classes;

use App\Repositories\CountryRepository;
use SoapClient;

class CompanyTaxNumber
{
    protected string $taxNumber;

    public function __construct(string $taxNumber)
    {
        $this->taxNumber = $taxNumber;
    }

    public function getCompanyDetailsByTaxNumber(): array
    {
        // ha nem betűvel kezdődik
        if (is_numeric($this->taxNumber[0])) {
            return $this->checkHungarianTaxNumber();
        }

        return $this->checkEuTaxNumber();
    }

    private function checkHungarianTaxNumber(): array
    {
        $taxNumber = str_replace('-', '', $this->taxNumber);

        if (strlen($taxNumber) == 11) {
            $config = new \NavOnlineInvoice\Config(
                'https://api.onlineszamla.nav.gov.hu/invoiceService/v3',
                config('riel.nav_user_data'),
                config('riel.nav_software_data')
            );

            $config->setCurlTimeout(70);

            $reporter = new \NavOnlineInvoice\Reporter($config);

            try {
                $taxNumber = substr($taxNumber, 0, 8);
                $result = $reporter->queryTaxpayer($taxNumber);

                if ($result) {
                    $address = $result->taxpayerAddressList->taxpayerAddressItem->taxpayerAddress;

                    return [
                        'countryId' => 0,
                        'companyName' => ucwords(mb_strtolower($result->taxpayerShortName)),
                        'address' => [
                            'zip' => $address->postalCode,
                            'city' => $this->upperFirstWithDashes(mb_strtolower($address->city)),
                            'street' => $this->upperFirstWithDashes(ucwords(mb_strtolower($address->streetName))) . ' ' . mb_strtolower($address->publicPlaceCategory) . ' ' . $address->number . '.',
                        ],
                    ];
                }

                return ['error' => 'Az adószám nem érvényes!'];
            } catch (\Exception $ex) {
                return ['error' => 'Az adószám lekérdezése során hiba lépett fel vagy az adószám nem érvényes!'];
            }
        } else {
            return ['error' => 'Az adószámnak 11 karakter hosszúnak kell lennie!'];
        }
    }

    private function checkEuTaxNumber(): array
    {
        try {
            $client = new SoapClient('https://ec.europa.eu/taxation_customs/vies/checkVatTestService.wsdl');
            $response = $client->__soapCall('checkVat', [$this->getCountryAndTaxNumber()]);

            if ($response->valid) {
                return [
                    'countryId' => (new CountryRepository())->getIdByCode($response->countryCode),
                    'companyName' => ucwords(mb_strtolower($response->name)),
                    'address' => [
                        'zip' => '',
                        'city' => '',
                        'street' => $this->upperFirstWithDashes(ucwords(mb_strtolower($response->address))),
                    ],
                ];
            }

            return ['error' => 'Az adószám nem megfelelő!'];
        } catch (\Exception $e) {
            switch ($e->getMessage()) {
                case 'INVALID_INPUT':
                    return ['error' => 'Az adószám nem megfelelő!'];

                case 'INVALID_REQUESTER_INFO':
                case 'SERVICE_UNAVAILABLE':
                case 'MS_UNAVAILABLE':
                case 'TIMEOUT':
                    return ['error' => 'Az adószám jelenleg nem lekérhető! Kérlek próbáld meg újra!'];

                default:
                    return ['error' => 'Az adószám lekérdezése során hiba lépett fel vagy az adószám nem érvényes!'];
            }
        }
    }

    private function upperFirstWithDashes(string $city): string
    {
        return implode('-', array_map('ucfirst', explode('-', $city)));
    }

    private function getCountryAndTaxNumber(): array
    {
        $countryCode = '';

        foreach (str_split($this->taxNumber) as $char) {
            if (! is_numeric($char)) {
                $countryCode .= $char;
            } else {
                break;
            }
        }

        return [
            'countryCode' => $countryCode,
            'vatNumber' => substr($this->taxNumber, strlen($countryCode)),
        ];
    }
}
