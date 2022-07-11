<?php 

namespace Durianpay\Resources;

class Order {
    public static $resourceUri = 'orders';

    public static function createOrder(array $body) {
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendCustomRequest(self::$resourceUri, [
            'method' => 'POST',
            'body' => $body
        ]);
        // return [$resBody, $resCode];
        return json_decode($resBody, true);
    }

    public static function fetchOrders(array $queryParams = [])
    {
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendCustomRequest(self::$resourceUri, [
            'method' => 'GET',
            'queryParams' => $queryParams
        ]);
        return json_decode($resBody, true);
    }
}