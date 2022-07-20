<?php

namespace Durianpay;

use Durianpay\Config as Config;

/**
 * Durianpay Class
 * 
 * Entity that stores the essential API key and need to be initiated first in the project.
 * 
 * @category Class
 * @link https://durianpay.id/docs
 * @author Ernest Salim <ernest.salim@durian.money>
 */
class Durianpay
{
    private static $_apiKey;

    /**
     * Durianpay class constructor
     *
     * @param  string $key
     */
    function __construct($key = "")
    {
        self::$_apiKey = $key;
        self::_setEnvironment();
    }

    /**
     * Set Durianpay's API key
     *
     * @param  string $key
     */
    public static function setApiKey(string $key): void
    {
        self::$_apiKey = $key;
        self::_setEnvironment();
    }

    /**
     * Return Durianpay's API key
     *
     * @return string
     */
    public static function getApiKey(): string
    {
        return self::$_apiKey;
    }

    /**
     * Set current environment based on API key
     */
    private static function _setEnvironment(): void {
        if (substr(self::$_apiKey, 3, 4) === 'test') Config::$environment = Config::SANDBOX_ENV;
        else if (substr(self::$_apiKey, 3, 4) === 'live') Config::$environment = Config::PROD_ENV;
        else Config::$environment = Config::PROD_ENV;
    }
}
