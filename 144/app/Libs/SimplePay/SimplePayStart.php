<?php

namespace App\Libs\SimplePay;

use App\Libs\SimplePay;

/**
 * Start transaction.
 *
 * @category SDK
 *
 * @author   SimplePay IT Support <itsupport@otpmobil.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @see      http://simplepartner.hu/online_fizetesi_szolgaltatas.html
 */
final class SimplePayStart extends SimplePay\Base
{

    public $transactionBase = [
        'salt' => '',
        'merchant' => '',
        'orderRef' => '',
        'currency' => '',
        'customerEmail' => '',
        'language' => '',
        'sdkVersion' => '',
        'methods' => [],
    ];
    protected $currentInterface = 'start';

    /**
     * Send initial data to SimplePay API for validation
     * The result is the payment link to where website has to redirect customer.
     */
    public function runStart()
    {
        $this->execApiCall();
    }
}