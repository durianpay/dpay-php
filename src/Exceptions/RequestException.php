<?php

namespace Durianpay\Exceptions;

use Exception;
use Throwable;

class RequestException extends Exception
{
    protected $stateCode;
    protected $desc;

    public function __construct($message, $code = 0, $stateCode = '', $desc = [])
    {
        // if (!$message) throw new $this('Unknown ' . get_class($this));
        $this->stateCode = $stateCode;
        $this->desc = $desc;
        parent::__construct($message, $code, null);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function getErrorStateCode(): string
    {
        return $this->stateCode;
    }

    public function getDetailedErrorDesc(): array
    {
        return $this->desc;
    }
}
