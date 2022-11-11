<?php

namespace App\Logging;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;

class CreateStackdriverLogger
{
    public function __invoke(array $config): Logger
    {
        $logName = $config['logName'] ?? 'app';
        $psrLogger = LoggingClient::psrBatchLogger($logName);
        $handler = new PsrHandler($psrLogger);

        return new Logger($logName, [$handler]);
    }
}
