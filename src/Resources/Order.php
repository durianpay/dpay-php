<?php

namespace Durianpay\Resources;

use \Durianpay\Resources\ResourceInterface as ResourceInterface;

/**
 * Order Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/orders/overview/
 */
class Order implements ResourceInterface
{
    // For Create and Fetch APIs
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    /**
     * Retrieve order APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'orders';
    }

    /**
     * Retrieve required options for a specific order API 
     *
     * @param  string $api
     *
     * @return array
     */ 
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

    /**
     * Create a payment link for a single order
     *
     * @param  array $body
     *
     * @return array
     */
    public static function createPaymentLink(array $body): array 
    {
        $uri = static::getResourceUri();
        $body['is_payment_link'] = true;
        $options = ['body' => $body];

        $res = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($res[0], true);
    }
}
