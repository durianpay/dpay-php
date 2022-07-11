<?php

namespace Durianpay\Http;

use Durianpay\Http\GuzzleClient as GuzzleClient;

class ApiClient
{

    public static function sendCustomRequest($uri, $options)
    {
        return GuzzleClient::getInstance()->request($uri, $options);
    }
}
