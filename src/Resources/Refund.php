<?php

namespace Durianpay\Resources;

/**
 * Refund Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/refunds/overview/
 */
class Refund implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    /**
     * Retrieve refund APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'refunds';
    }

    /**
     * Retrieve required options for a specific refund API 
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
