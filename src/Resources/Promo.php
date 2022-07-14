<?php

namespace Durianpay\Resources;

class Promo implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;
    use \Durianpay\Http\PresetOperations\Delete;

    public static function getResourceUri(): string
    {
        return 'merchants/promos';
    }

    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'create':
                return [
                    'body' => [
                        'currency',
                        'label',
                        'type',
                        'sub_type',
                        'min_order_amount',
                        'max_discount_amount',
                        'starts_at',
                        'ends_at',
                        'discount',
                        'discount_type',
                        'limit_type',
                        'price_deduction_type',
                        'promo_details'
                    ]
                ];
            default:
                return [];
        }
    }

    public static function update(string $id, array $body): array
    {
        $uri = self::getResourceUri() . '/' . $id;
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('PATCH', $uri, $options);
        return json_decode($resBody, true);
    }
}
