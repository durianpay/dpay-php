<?php

namespace Durianpay\Exceptions;

use Exception;
use Throwable;

/**
 * Request Exception
 * 
 * @category Exception
 */
class RequestException extends Exception implements Throwable
{
    protected $stateCode;
    protected $desc;

    /**
     * Request exception class constructor
     *
     * @param  string  $message
     * @param  integer $code
     * @param  string  $stateCode
     * @param  array   $desc
     */
    public function __construct(string $message, int $code = 0, string $stateCode = '', array $desc = [])
    {
        if (!$message) throw new $this('Unknown ' . __CLASS__);
        $this->stateCode = $stateCode;
        $this->desc = $desc;
        parent::__construct($message, $code, null);
    }

    /**
     * String representation of a request exception
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Retrieve the error state code
     *
     * @return string
     */
    public function getErrorStateCode(): string
    {
        return $this->stateCode;
    }

    /**
     * Retrieve an object of detailed explanation of the error
     *
     * @return array
     */
    public function getDetailedErrorDesc(): array
    {
        if (!$this->desc) return ['Unknown details'];
        return $this->desc;
    }
}
