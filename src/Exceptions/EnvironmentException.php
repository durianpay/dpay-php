<?php

namespace Durianpay\Exceptions;

use Exception;
use Throwable;

/**
 * Environment Exception
 * 
 * @category Exception
 */
class EnvironmentException extends Exception implements Throwable
{
    protected $currentEnv;

    /**
     * Environment exception class constructor
     *
     * @param  string $message
     * @param  string $currentEnv
     */
    public function __construct(string $message, string $currentEnv)
    {
        if (!$message) throw new $this('Unknown ' . __CLASS__);
        $this->currentEnv = $currentEnv;
        parent::__construct($message);
    }

    /**
     * String representation of an environment exception
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": Feature is not supported in {$this->currentEnv} mode. \n";
    }
}
