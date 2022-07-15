<?php

namespace Durianpay\Resources;

/**
 * Settlement Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/settlements/settlements-fetch-list/
 */
class Settlement implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    /**
     * Retrieve settlement APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'settlements';
    }

    /**
     * Retrieve required options for a specific settlement API 
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
     * Fetch details of multiple settlements
     *
     * @param  array $queryParams
     *
     * @return array
     */
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

    /**
     * Fetch settlement status of a single payment
     *
     * @param  string $paymentID
     *
     * @return array
     */
    public static function fetchSettlementStatus(string $paymentID): array
    {
        $uri = self::getResourceUri() . '/details';
        $options = ['queryParams' => ['payment_id' => $paymentID]];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri, $options);
        return json_decode($resBody, true);
    }
}
