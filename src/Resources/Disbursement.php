<?php

namespace Durianpay\Resources;

class Disbursement implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\FetchOne;
    use \Durianpay\Http\PresetOperations\Delete;

    public static function getResourceUri(): string
    {
        return 'disbursements';
    }

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
                        'indempotency_key'
                    ]
                ];
            default:
                return [];
        }
    }

    public static function fetchAvailableBanks(): array
    {
        $uri = self::getResourceUri() . '/banks';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    public static function topUp(array $body): array
    {
        $uri = self::getResourceUri() . '/topup';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options, self::getRequiredOptions('topup'));
        return json_decode($resBody, true);
    }

    public static function fetchTopUpDetails(string $id): array
    {
        $uri = self::getResourceUri() . '/topup/' . $id;
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    public static function fetchBalance(): array
    {
        $uri = self::getResourceUri() . '/topup/balance';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }

    public static function submit(array $body, array $queryParams = [], string $idempotencyKey = ''): array
    {
        $uri = self::getResourceUri() . '/submit';
        if ($idempotencyKey === '') $idempotencyKey = strval(rand(100000, 1000000) + 1);

        $options = [
            'body' => $body,
            'queryParams' => $queryParams,
            'headers' => ['idempotency_key' => $idempotencyKey]
        ];

        // Implement precall request validator in the future
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    public static function validate(array $body): array
    {
        $uri = self::getResourceUri() . '/validate';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    public static function approve(string $id, bool $ignoreInvalid = true): array
    {
        $uri = self::getResourceUri() . '/' . $id . '/approve';
        $options = ['queryParams' => ['ignore_invalid' => $ignoreInvalid]];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    public static function fetchDisbursementItems(string $id): array 
    {
        $uri = self::getResourceUri() . '/' . $id . '/items';
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('GET', $uri);
        return json_decode($resBody, true);
    }
}
