<?php

namespace Durianpay\Resources;

use \Durianpay\Http\ApiClient as ApiClient;

class Order
{
    // For Create and Fetch APIs
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    public static function getResourceUri()
    {
        return 'orders';
    }

    public static function getRequiredOptions()
    {
        return [
            'body' => [
            'amount',
            'currency',
            'customer' => [
                'given_name',
                'email'
            ]
        ]];
    }
}
