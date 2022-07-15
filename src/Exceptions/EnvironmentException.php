<?php

namespace Durianpay\Exceptions;

use Exception;
use Throwable;

class EnvironmentException extends Exception implements Throwable
{
    protected $currentEnv;

    public function __construct(string $message, string $currentEnv)
    {
        if (!$message) throw new $this('Unknown ' . __CLASS__);
        $this->currentEnv = $currentEnv;
        parent::__construct($message);
    }

    public function __toString()
    {
        return __CLASS__ . ": Feature is not supported in {$this->currentEnv} mode. \n";
    }
}
