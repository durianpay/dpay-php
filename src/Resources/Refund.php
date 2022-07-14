<?php

namespace Durianpay\Resources;

class Refund implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    public static function getResourceUri(): string
    {
        return 'refunds';
    }

    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'create':
                return [
                    'body' => [
                        'ref_id', 
                        'payment_id', 
                        'amount', 
                        'customer_id', 
                        'notes']
                ];
            default:
                return [];
        }
    }
}
