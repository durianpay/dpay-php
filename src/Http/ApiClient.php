<?php

namespace Durianpay\Http;

use Durianpay\Http\GuzzleClient as GuzzleClient;

class ApiClient
{
    public static function sendRequest($uri, $options)
    {
        return GuzzleClient::getInstance()->request($uri, $options);
    }
}
