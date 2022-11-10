<?php

namespace App\Libs\SimplePay;

use App\Libs\SimplePay;
use Exception;

/**
 * IPN.
 *
 * @category SDK
 *
 * @author   SimplePay IT Support <itsupport@otpmobil.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @see      http://simplepartner.hu/online_fizetesi_szolgaltatas.html
 */
class SimplePayIpn extends SimplePay\Base
{
    public $validationResult = false;
    protected $currentInterface = 'ipn';
    protected $returnData = [];
    protected $receiveDate = '';
    protected $ipnContent = [];
    protected $responseContent = '';
    protected $ipnReturnData = [];

    /**
     * IPN validation.
     *
     * @param string $content IPN content
     *
     * @return bool
     */
    public function isIpnSignatureCheck($content = '')
    {
        $signature = $this->getSignatureFromHeader(getallheaders());

        foreach (json_decode($this->checkOrSetToJson($content)) as $key => $value) {
            $this->ipnContent[$key] = $value;
        }

        if (isset($this->ipnContent['merchant'])) {
            $this->addConfigData('merchantAccount', $this->ipnContent['merchant']);
        }
        $this->setConfig();

        $this->validationResult = false;
        if ($this->isCheckSignature($content, $signature)) {
            $this->validationResult = true;
        }
        $this->logContent['ipnBodyToValidation'] = $content;

        $this->logTransactionId = $this->ipnContent['transactionId'];
        $this->logOrderRef = $this->ipnContent['orderRef'];
        // $this->writeLog(['validationResult' => $this->validationResult]);

        foreach ($this->ipnContent as $contentKey => $contentValue) {
            $this->logContent[$contentKey] = $contentValue;
        }
        $this->logContent['validationResult'] = $this->validationResult;

        if (! $this->validationResult) {
            $this->logContent['validationResultMessage'] = 'UNSUCCESSFUL VALIDATION, NO CONFIRMATION';
        }
        // $this->writeLog($this->logContent);

        //confirm setup
        if (! $this->validationResult) {
            $this->confirmContent = 'UNSUCCESSFUL VALIDATION';
            $this->signature = 'UNSUCCESSFUL VALIDATION';
        } elseif ($this->validationResult) {
            $this->ipnContent['receiveDate'] = @date('c', time());
            $this->confirmContent = json_encode($this->ipnContent);
            $this->signature = $this->getSignature($this->config['merchantKey'], $this->confirmContent);
        }
        $this->ipnReturnData['signature'] = $this->signature;
        $this->ipnReturnData['confirmContent'] = $this->confirmContent;
        // $this->writeLog(['confirmSignature' => $this->signature, 'confirmContent' => $this->confirmContent]);

        return $this->validationResult;
    }

    /**
     * Immediate IPN confirmation.
     *
     * @return bool
     */
    public function runIpnConfirm()
    {
        try {
            header('Accept-language: EN');
            header('Content-type: application/json');
            header('Signature: ' . $this->ipnReturnData['signature']);
            echo $this->ipnReturnData['confirmContent'];
        } catch (Exception $e) {
            // $this->writeLog(['ipnConfirm' => $e->getMessage()]);
            return false;
        }
        // $this->writeLog(['ipnConfirm' => 'Confirmed directly by runIpnConfirm']);
        return true;
    }

    /**
     * IPN confirmation data.
     *
     * @return array $this->ipnReturnData Content and signature for mercaht system
     */
    public function getIpnConfirmContent()
    {
        // $this->writeLog(['ipnConfirm' => 'ipnReturnData provided as content by getIpnConfirmContent']);
        return $this->ipnReturnData;
    }
}
