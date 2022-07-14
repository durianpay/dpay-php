<?php

namespace Durianpay\Resources;

class Subscription implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    public static function getResourceUri(): string
    {
        return 'subscriptions';
    }

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

    public statIc function cancel(string $id): array {
        $uri = self::getResourceUri() . '/' . $id . '/cancel';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('DELETE', $uri);
        return json_decode($resBody, true);
    }
}
