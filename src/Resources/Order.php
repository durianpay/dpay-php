<?php

namespace Durianpay\Resources;

use \Durianpay\Resources\ResourceInterface as ResourceInterface;

class Order implements ResourceInterface
{
    // For Create and Fetch APIs
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    public static function getResourceUri(): string
    {
        return 'orders';
    }

    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'create':
                return [
                    'body' => [
                        'amount',
                        'currency',
                        'customer' => [
                            'given_name',
                            'email'
                        ],
                        'items',
                    ]
                ];
            case 'payment-link':
                return [
                    'body' => [
                        'amount',
                        'currency',
                        'customer' => [
                            'given_name',
                            'email'
                        ],
                        'items',
                        'is_payment_link',
                    ]
                    ];
            default:
                return [];
        }
    }

    public static function createPaymentLink(array $body): array 
    {
        $uri = static::getResourceUri();
        $body['is_payment_link'] = true;
        $options = ['body' => $body];

        $res = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($res[0], true);
    }
}
