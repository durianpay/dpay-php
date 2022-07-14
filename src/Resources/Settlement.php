<?php

namespace Durianpay\Resources;

class Settlement implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    public static function getResourceUri(): string
    {
        return 'settlements';
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

    public static function fetchDetails(array $queryParams = []): array
    {
        $uri = self::getResourceUri() . '/details';
        if (!array_key_exists('limit', $queryParams)) {
            $queryParams['limit'] = 5;
        }
        $options = ['queryParams' => $queryParams];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri, $options);
        return json_decode($resBody, true);
    }

    public static function fetchSettlementStatus(string $paymentID): array
    {
        $uri = self::getResourceUri() . '/details';
        $options = ['queryParams' => ['payment_id' => $paymentID]];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri, $options);
        return json_decode($resBody, true);
    }
}
