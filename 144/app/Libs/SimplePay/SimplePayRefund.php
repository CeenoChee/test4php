<?php

namespace App\Libs\SimplePay;

use App\Libs\SimplePay;

/**
 * Refund.
 *
 * @category SDK
 *
 * @author   SimplePay IT Support <itsupport@otpmobil.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @see      http://simplepartner.hu/online_fizetesi_szolgaltatas.html
 */
class SimplePayRefund extends SimplePay\Base
{

    public $transactionBase = [
        'salt' => '',
        'merchant' => '',
        'orderRef' => '',
        'transactionId' => '',
        'currency' => '',
    ];
    protected $currentInterface = 'refund';
    protected $returnData = [];

    /**
     * Run refund.
     *
     * @return array $result API response
     */
    public function runRefund()
    {
        if ($this->transactionBase['orderRef'] == '') {
            unset($this->transactionBase['orderRef']);
        }
        if ($this->transactionBase['transactionId'] == '') {
            unset($this->transactionBase['transactionId']);
        }
        $this->logTransactionId = @$this->transactionBase['transactionId'];
        $this->logOrderRef = @$this->transactionBase['orderRef'];

        return $this->execApiCall();
    }
}