<?php

namespace Durianpay;

use Durianpay\Config as Config;

class Durianpay
{
    public static $apiKey;

    function __construct($key = "")
    {
        self::$apiKey = $key;
        self::_setEnvironment();
    }

    public static function setApiKey($key): void
    {
        self::$apiKey = $key;
        self::_setEnvironment();
    }

    public static function getApiKey(): string
    {
        return self::$apiKey;
    }

    private static function _setEnvironment(): void {
        if (substr(self::$apiKey, 3, 4) === 'test') Config::$environment = 'sandbox';
        else if (substr(self::$apiKey, 3, 4) === 'live') Config::$environment = 'production';
        else Config::$environment = 'production';
    }
}
