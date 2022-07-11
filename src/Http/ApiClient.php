<?php

namespace Durianpay\Http;

use Durianpay\Http\GuzzleClient as GuzzleClient;

class ApiClient
{
    public static function sendRequest($method, $uri, $options = []): array
    {
        return GuzzleClient::getInstance()->request($method, $uri, $options);
    }
}