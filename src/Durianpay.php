<?php

namespace Durianpay;

class Durianpay
{
    public static $apiKey;

    function __construct($key = "")
    {
        self::$apiKey = $key;
    }

    public static function setApiKey($key): void
    {
        self::$apiKey = $key;
    }

    public static function getApiKey(): string
    {
        return self::$apiKey;
    }
}
