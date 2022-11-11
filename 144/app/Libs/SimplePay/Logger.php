<?php

namespace App\Libs\SimplePay;

use Exception;

/**
 * Logger.
 *
 * @category SDK
 *
 * @author   SimplePay IT Support <itsupport@otpmobil.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GENERAL PUBLIC LICENSE (GPL V3.0)
 *
 * @see     http://simplepartner.hu/online_fizetesi_szolgaltatas.html
 */
trait Logger
{
    /**
     * Prepare log content before write in into log.
     *
     * @param array $log Optional content of log. Default is $this->logContent
     *
     * @return bool
     */
    public function writeLog($log = [])
    {
        $write = true;
        if (count($log) == 0) {
            $log = $this->logContent;
        }

        $date = @date('Y-m-d H:i:s', time());
        $logFile = $this->config['logPath'] . '/' . @date('Ymd', time()) . '.log';

        try {
            if (! is_writable($this->config['logPath'])) {
                $write = false;

                throw new Exception('Folder is not writable: ' . $this->config['logPath']);
            }
            if (file_exists($logFile)) {
                if (! is_writable($logFile)) {
                    $write = false;

                    throw new Exception('File is not writable: ' . $logFile);
                }
            }
        } catch (Exception $e) {
            $this->logContent['logFile'] = $e->getMessage();
        }

        if ($write) {
            $flat = $this->getFlatArray($log);
            if (isset($flat['cardSecret'])) {
                unset($flat['cardSecret']);
            }

            $logText = '';
            foreach ($flat as $key => $value) {
                $logText .= $this->logOrderRef . $this->logSeparator;
                $logText .= $this->logTransactionId . $this->logSeparator;
                $logText .= $this->currentInterface . $this->logSeparator;
                $logText .= $date . $this->logSeparator;
                $logText .= $key . $this->logSeparator;
                $logText .= $value . "\n";
            }

            $this->logToFile($logFile, $logText);
            unset($log, $flat, $logText);

            return true;
        }

        return false;
    }

    /**
     * Write log into file.
     *
     * @param array $logFile Log file
     * @param array $logText Log content
     *
     * @return bool
     */
    protected function logToFile($logFile = '', $logText = '')
    {
        try {
            if (! file_put_contents($logFile, $logText, FILE_APPEND | LOCK_EX)) {
                throw new Exception('Log write error');
            }
        } catch (Exception $e) {
            $this->logContent['logToFile'] = $e->getMessage();
        }
        unset($logFile, $logText);
    }
}
