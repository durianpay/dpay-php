<?php

namespace Durianpay\Resources;

/**
 * Disbursement Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/disbursements/fetch-banks/
 */
class Disbursement implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\FetchOne;
    use \Durianpay\Http\PresetOperations\Delete;

    /**
     * Retrieve disbursement APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'disbursements';
    }

    /**
     * Retrieve required options for a specific disbursement API 
     *
     * @param  string $api
     *
     * @return array
     */ 
    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'topup':
                return [
                    'body' => ['bank_id', 'amount']
                ];
            case 'submit':
                return [
                    'body' => [
                        'name',
                        'description',
                        'items' => [[
                            'account_owner_name',
                            'bank_code',
                            'amount',
                            'account_number',
                            'email_recipient',
                            'phone_number'
                        ]]
                    ],
                    'headers' => [
                        'idempotency_key'
                    ]
                ];
            case 'validate':
                return [
                    'body' => ['account_number', 'bank_code']
                ];
            default:
                return [];
        }
    }

    /**
     * Fetch a list of available banks to execute disbursement processes
     *
     * @return array
     */
    public static function fetchAvailableBanks(): array
    {
        $uri = self::getResourceUri() . '/banks';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    /**
     * Top up Durianpay account balance
     *
     * @param  array $body
     *
     * @return array
     */
    public static function topUp(array $body): array
    {
        $uri = self::getResourceUri() . '/topup';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Fetch details of a single top-up history
     *
     * @param  string $id
     *
     * @return array
     */
    public static function fetchTopUpDetails(string $id): array
    {
        $uri = self::getResourceUri() . '/topup/' . $id;
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    /**
     * Fetch the amount inside Durianpay's balance
     *
     * @return array
     */
    public static function fetchBalance(): array
    {
        $uri = self::getResourceUri() . '/topup/balance';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    /**
     * Submit disbursement request
     *
     * @param  array  $body
     * @param  array  $queryParams
     * @param  string $idempotencyKey
     *
     * @return array
     */
    public static function submit(array $body, string $idempotencyKey, array $queryParams = []): array
    {
        $uri = self::getResourceUri() . '/submit';
        // if ($idempotencyKey === '') $idempotencyKey = strval(rand(100000, 1000000) + 1);

        $options = [
            'body' => $body,
            'queryParams' => $queryParams,
            'headers' => ['idempotency_key' => $idempotencyKey]
        ];

        // Implement precall request validator in the future
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Validate a single disbursement request
     *
     * @param  array $body
     *
     * @return array
     */
    public static function validate(array $body): array
    {
        $uri = self::getResourceUri() . '/validate';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Approve a single disbursement request
     *
     * @param  string  $id
     * @param  boolean $ignoreInvalid
     *
     * @return array
     */
    public static function approve(string $id, bool $ignoreInvalid = true): array
    {
        $uri = self::getResourceUri() . '/' . $id . '/approve';
        $options = ['queryParams' => ['ignore_invalid' => $ignoreInvalid]];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Fetch a list of items from a single disbursement
     *
     * @param  string $id
     *
     * @return array
     */
    public static function fetchDisbursementItems(string $id): array
    {
        $uri = self::getResourceUri() . '/' . $id . '/items';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }
}
