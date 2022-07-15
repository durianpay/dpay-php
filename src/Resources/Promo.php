<?php

namespace Durianpay\Resources;

/**
 * Promo Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/promos/overview/
 */
class Promo implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;
    use \Durianpay\Http\PresetOperations\Delete;

    /**
     * Retrieve promo APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'merchants/promos';
    }

    /**
     * Retrieve required options for a specific promo API 
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

    /**
     * Update a single promo object
     *
     * @param  string $id
     * @param  array  $body
     *
     * @return array
     */
    public static function update(string $id, array $body): array
    {
        $uri = self::getResourceUri() . '/' . $id;
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('PATCH', $uri, $options);
        return json_decode($resBody, true);
    }
}
