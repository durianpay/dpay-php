<?php

namespace Durianpay\Exceptions;

use Exception;
use Throwable;

class RequestException extends Exception implements Throwable
{
    protected $stateCode;
    protected $desc;

    public function __construct(string $message, int $code = 0, string $stateCode = '', array $desc = [])
    {
        if (!$message) throw new $this('Unknown ' . __CLASS__);
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
        if (!$this->desc) return ['Unknown details'];
        return $this->desc;
    }
}
