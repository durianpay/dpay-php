<?php 

namespace Durianpay\Resources;

class Order {
    public static $resourceUri = 'orders';

    public static function createOrder($body) {
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest(self::$resourceUri, [
            'method' => 'POST',
            'body' => $body
        ]);
        return json_decode($resBody, true);
    }


}