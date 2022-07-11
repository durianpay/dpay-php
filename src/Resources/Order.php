<?php

namespace Durianpay\Resources;

use \Durianpay\Http\ApiClient as ApiClient;

class Order
{
    // For Create and Fetch APIs
    use \Durianpay\Http\RequestPresets;

    public static function getResourceUri()
    {
        return 'orders/';
    }

    public static function fetchOne(string $id, array $queryParams = [])
    {
        $uri = self::getResourceUri() . $id;
        [$resBody, $resCode, $resHeaders] = ApiClient::sendRequest('GET', $uri, ['queryParams' => $queryParams]);
        return json_decode($resBody, true);
    }
}