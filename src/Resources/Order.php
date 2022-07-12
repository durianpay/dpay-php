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
                        ]
                    ]
                ];
            default:
                return [];
        }
    }
}
