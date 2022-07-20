<?php

namespace Durianpay;

/**
 * Class Config
 * 
 * @category Class
 * @link https://durianpay.id/docs
 */
class Config
{
    const IDR_CURRENCY = 'IDR';
    const USD_CURRENCY = 'USD';
    const PROD_ENV = 'production';
    const SANDBOX_ENV = 'sandbox';

    public static $defaultTimeout = 10;
    public static $defaultCurrency = self::IDR_CURRENCY;
    public static $baseUrl = 'https://api.durianpay.id/v1/';
    public static $environment = self::PROD_ENV;
}
