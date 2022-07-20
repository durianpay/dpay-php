<?php

namespace Durianpay\Resources;

use \Durianpay\Resources\ResourceInterface as ResourceInterface;

/**
 * Payment Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/payments/overview/
 */
class Payment implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    /**
     * Retrieve payment APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'payments';
    }

    /**
     * Retrieve required options for a specific payment API 
     *
     * @param  string $api
     *
     * @return array
     */ 
    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'charge-va':
                return [
                    'body' => [
                        'type',
                        'request' => [
                            'order_id', 'bank_code', 'name', 'amount'
                        ]
                    ]

                ];
            case 'charge-ewallet':
                return [
                    'body' => [
                        'type',
                        'request' => [
                            'order_id', 'mobile', 'wallet_type', 'amount'
                        ]
                    ]

                ];
            case 'charge-retailstore':
                return [
                    'body' => [
                        'type',
                        'request' => [
                            'order_id', 'bank_code', 'name', 'amount'
                        ]
                    ]

                ];
            case 'charge-onlinebanking':
                return [
                    'body' => [
                        'type',
                        'request' => [
                            'order_id', 'mobile', 'name', 'amount', 'type'
                        ]
                    ]

                ];
            case 'verify':
                return ['body' => ['verification_signature']];
            case 'mdr-fees-calculation':
                return ['queryParams' => ['amount']];
            default:
                return [];
        }
    }

    /**
     * Create a payment charge call
     *
     * @param  string $type
     * @param  array  $request
     *
     * @return array
     */
    public static function charge(string $type, array $request): array
    {
        $type = strtoupper($type);
        $uri = self::getResourceUri() . '/charge';
        $options = ['body' => [
            'type' => $type,
            'request' => $request
        ]];
        $requiredOptions = [];

        if ($type === 'VA') $requiredOptions = self::getRequiredOptions('charge-va');
        if ($type === 'EWALLET') $requiredOptions = self::getRequiredOptions('charge-ewallet');
        if ($type === 'RETAILSTORE') $requiredOptions = self::getRequiredOptions('charge-retailstore');
        if ($type === 'ONLINE_BANKING') $requiredOptions = self::getRequiredOptions('charge-onlinebanking');

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);

        return json_decode($resBody, true);
    }

    /**
     * Check the status of a single payment
     *
     * @param  string $id
     *
     * @return array
     */
    public static function checkStatus(string $id): array
    {
        $uri = self::getResourceUri() . '/' . $id . '/status';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    /**
     * Verify a single payment using signature
     *
     * @param  string $id
     * @param  string $verificationSignature
     *
     * @return array
     */
    public static function verify(string $id, string $verificationSignature): array
    {
        $uri = self::getResourceUri() . '/' . $id . '/verify';
        $options = ['body' => [
            'verification_signature' => $verificationSignature
        ]];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Cancel a single payment charge
     *
     * @param  string $id
     *
     * @return array
     */
    public static function cancel(string $id): array
    {
        $uri = self::getResourceUri() . '/' . $id . '/cancel';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('PUT', $uri);
        return json_decode($resBody, true);
    }

    /**
     * Calculate MDR fees
     *
     * @param  array $queryParams
     *
     * @return array
     */
    public static function calculateMDRFees(array $queryParams): array
    {
        $uri = 'merchants/mdr_fees';

        if (!array_key_exists('payment_method', $queryParams)) {
            $queryParams['payment_method'] = 'all';
        }
        $options = ['queryParams' => $queryParams];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri, $options);
        return json_decode($resBody, true);
    }
}
