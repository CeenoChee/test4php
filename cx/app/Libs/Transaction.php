<?php

namespace App\Libs;

use App\Libs\SimplePay\SimplePayBack;
use App\Libs\SimplePay\SimplePayStart;
use App\Models\CustomerEmployee;
use App\Models\Transaction as TransactionModel;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Transaction
{
    private $customerEmployee;
    private $netTotal;
    private $backUrl;
    private $type = '';
    private $data;
    private $deliveryAddress;

    public function __construct(CustomerEmployee $customerEmployee, Price $netTotal, $backUrl)
    {
        $this->customerEmployee = $customerEmployee;
        $this->netTotal = $netTotal;
        $this->backUrl = $backUrl;
    }

    public function setContact($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function setDeliveryAddress(Address $cim = null)
    {
        $this->deliveryAddress = $cim;
    }

    public function start()
    {
        $customer = $this->customerEmployee->customer;
        $billingAddress = $customer->getAddress();

        if ($customer->isForeigner()) {
            $grossTotal = $this->netTotal;
        } else {
            $grossTotal = $this->netTotal->multiplication(1 + (config('riel.tax', 27) / 100));
        }

        $lang = app('Lang')->getLocale();

        $billingCountry = $billingAddress->getCountry();
        $deliveryCountry = $this->deliveryAddress ? $this->deliveryAddress->getCountry() : null;

        $currency = $this->netTotal->getCurrency();

        $transaction = new TransactionModel();
        $transaction->Ugyfel_ID = $this->customerEmployee->Ugyfel_ID;
        $transaction->UgyfelDolgozo_ID = $this->customerEmployee->UgyfelDolgozo_ID;
        $transaction->NettoOsszeg = $this->netTotal->getRoundedAmount();
        $transaction->BruttoOsszeg = $grossTotal->getRoundedAmount();
        $transaction->Deviza_ID = $this->netTotal->getCurrencyID();
        $transaction->Tipus = $this->type;
        $transaction->Adat = $this->data;
        $transaction->ResponseCode = null;
        $transaction->TransactionID = null;
        $transaction->Event = null;
        $transaction->Merchant = null;
        $transaction->save();

        $simplePay = new SimplePayStart();
        $simplePay->addData('currency', $currency);
        $simplePay->addConfigData($currency . '_MERCHANT', config('riel.simplepay.' . $currency . '_MERCHANT'));
        $simplePay->addConfigData($currency . '_SECRET_KEY', config('riel.simplepay.' . $currency . '_SECRET_KEY'));
        $simplePay->addConfigData('SANDBOX', config('riel.simplepay.SANDBOX'));
        $simplePay->addData('total', $grossTotal->getTotal());
        $simplePay->addData('orderRef', $transaction->Tranzakcio_ID . '-' . (new DateTime())->getTimestamp());
        $simplePay->addData('customer', $billingAddress->getName());
        $simplePay->addData('customerEmail', $this->customerEmployee->WebLogin);
        $simplePay->addData('language', $lang);
        $simplePay->addData('timeout', date('c', time() + config('riel.simplepay.TIMEOUT')));
        $simplePay->addData('methods', ['CARD']);

        $appUrl = env('APP_URL');

        $simplePay->addGroupData('urls', 'success', $appUrl . $this->backUrl);
        $simplePay->addGroupData('urls', 'fail', $appUrl . $this->backUrl);
        $simplePay->addGroupData('urls', 'cancel', $appUrl . $this->backUrl);
        $simplePay->addGroupData('urls', 'timeout', $appUrl . $this->backUrl);

        $simplePay->addGroupData('invoice', 'name', $this->customerEmployee->Nev);
        $simplePay->addGroupData('invoice', 'company', $billingAddress->getName());
        $simplePay->addGroupData('invoice', 'country', $billingCountry ? $billingCountry->KodAlpha2 : 'HU');
        // $simplePay->addGroupData('invoice', 'state', '');
        $simplePay->addGroupData('invoice', 'city', $billingAddress->getCity());
        $simplePay->addGroupData('invoice', 'zip', $billingAddress->getPostcode());
        $simplePay->addGroupData('invoice', 'address', $billingAddress->getStreetHouseNumber());
        // $simplePay->addGroupData('invoice', 'address2', '');
        $simplePay->addGroupData('invoice', 'phone', $this->customerEmployee->Mobil);

        if ($this->deliveryAddress !== null) {
            $simplePay->addGroupData('delivery', 'name', $this->deliveryAddress->getName());
            $simplePay->addGroupData('delivery', 'company', $billingAddress->getName());
            $simplePay->addGroupData('delivery', 'country', $deliveryCountry ? $deliveryCountry->KodAlpha2 : 'HU');
            // $simplePay->addGroupData('delivery', 'state', '');
            $simplePay->addGroupData('delivery', 'city', $this->deliveryAddress->getCity());
            $simplePay->addGroupData('delivery', 'zip', $this->deliveryAddress->getPostcode());
            $simplePay->addGroupData('delivery', 'address', $this->deliveryAddress->getStreetHouseNumber());
            // $simplePay->addGroupData('delivery', 'address2', '');
            // $simplePay->addGroupData('delivery', 'phone', '');
        }

        $simplePay->formDetails['element'] = 'auto';
        $simplePay->runStart();

        if (isset($simplePay->returnData['errorCodes'])) {
            Log::channel('single')->info('SimplePay error code: ' . $simplePay->returnData['errorCodes'][0]);

            flash()->error('A SimplePay szolgáltatásában fennakadások észlelhetőek. Kérjük válassz másik fizetési módot, vagy próbálkozz újra.');

            return redirect()->route(LUrl::name('billing'));
        }

        return $simplePay->returnData['paymentUrl'];
    }

    public static function back(Request $request)
    {
        // Tranzakció
        $transaction = null;
        if (isset($request->r)) {
            $r = @base64_decode($request->r);
            if ($r) {
                $r = @json_decode($r);
                if ($r && isset($r->o)) {
                    $transaction = TransactionModel::where('Tranzakcio_ID', (int) $r->o)->first();
                }
            }
        }

        if ($transaction && isset($request->s)) {
            $currency = $transaction->currency->Deviza;

            $simplePay = new SimplePayBack();

            $simplePay->addData('currency', $currency);
            $simplePay->addConfigData($currency . '_MERCHANT', config('riel.simplepay.' . $currency . '_MERCHANT'));
            $simplePay->addConfigData($currency . '_SECRET_KEY', config('riel.simplepay.' . $currency . '_SECRET_KEY'));
            $simplePay->addConfigData('SANDBOX', config('riel.simplepay.SANDBOX'));

            if ($simplePay->isBackSignatureCheck($request->r, $request->s)) {
                $result = $simplePay->getRawNotification();
            }

            if (isset($result)) {
                $transaction->ResponseCode = $result['r'];
                $transaction->TransactionID = $result['t'];
                $transaction->Event = $result['e'];
                $transaction->Merchant = $result['m'];
                $transaction->save();

                return $transaction;
            }
        }

        return null;
    }
}
