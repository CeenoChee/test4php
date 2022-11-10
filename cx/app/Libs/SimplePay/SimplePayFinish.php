<?php

namespace App\Libs\SimplePay;

use App\Libs\SimplePay;

/**
 * Finish.
 *
 * @category SDK
 *
 * @author   SimplePay IT Support <itsupport@otpmobil.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @see      http://simplepartner.hu/online_fizetesi_szolgaltatas.html
 */
class SimplePayFinish extends SimplePay\Base
{

    public $transactionBase = [
        'salt' => '',
        'merchant' => '',
        'orderRef' => '',
        'transactionId' => '',
        'originalTotal' => '',
        'approveTotal' => '',
        'currency' => '',
    ];
    protected $currentInterface = 'finish';
    protected $returnData = [];

    /**
     * Run finish.
     *
     * @return array $result API response
     */
    public function runFinish()
    {
        return $this->execApiCall();
    }
}