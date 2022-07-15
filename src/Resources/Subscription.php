<?php

namespace Durianpay\Resources;

/**
 * Subscription Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/subscriptions/overview/
 */
class Subscription implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    /**
     * Retrieve subscription APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'subscriptions';
    }

    /**
     * Retrieve required options for a specific subscription API
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
                        'plan' => [
                            'name', 
                            'billing_period',
                            'billing_period_count',
                            'grace_period',
                            'grace_period_count',
                            'price',
                            'qty'
                        ],
                        'customer' => [
                            'email', 
                            'mobile',
                            'given_name',
                            'sur_name'
                        ],
                        'billing_cycle_count',
                        'started_at',
                        'charge_type'
                    ]
                ];
            default:
                return [];
        }
    }

    /**
     * Cancel a specific subscription
     *
     * @param  string $id
     *
     * @return array
     */
    public statIc function cancel(string $id): array {
        $uri = self::getResourceUri() . '/' . $id . '/cancel';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('DELETE', $uri);
        return json_decode($resBody, true);
    }
}
