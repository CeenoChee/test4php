<?php

namespace App\Libs\SimplePay;

use App\Libs\SimplePay;

/**
 * Query.
 *
 * @category SDK
 *
 * @author   SimplePay IT Support <itsupport@otpmobil.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @see      http://simplepartner.hu/online_fizetesi_szolgaltatas.html
 */
class SimplePayQuery extends SimplePay\Base
{

    protected $currentInterface = 'query';
    protected $returnData = [];
    protected $transactionBase = [
        'salt' => '',
        'merchant' => '',
        'refundTotal' => '',
        'currency' => '',
    ];

    /**
     * Add SimplePay transaction ID to query.
     *
     * @param string $simplePayId SimplePay transaction ID
     */
    public function addSimplePayId($simplePayId = '')
    {
        if ( ! isset($this->transactionBase['transactionIds']) || count($this->transactionBase['transactionIds']) == 0) {
            $this->logTransactionId = $simplePayId;
        }
        $this->transactionBase['transactionIds'][] = $simplePayId;
    }

    /**
     * Add merchant order ID to query.
     *
     * @param string $merchantOrderId Merchant order ID
     */
    public function addMerchantOrderId($merchantOrderId = '')
    {
        if ( ! isset($this->transactionBase['orderRefs']) || count($this->transactionBase['orderRefs']) == 0) {
            $this->logOrderRef = $merchantOrderId;
        }
        $this->transactionBase['orderRefs'][] = $merchantOrderId;
    }

    /**
     * Run transaction data query.
     *
     * @return array $result API response
     */
    public function runQuery()
    {
        return $this->execApiCall();
    }
}