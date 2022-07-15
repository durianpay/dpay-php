<?php

namespace Durianpay\Resources;

class EwalletAccount implements ResourceInterface
{
    public static function getResourceUri(): string
    {
        return 'ewallet/account';
    }

    public static function getRequiredOptions(string $api): array
    {
        switch ($api) {
            case 'link':
                return [
                    'body' => ['mobile', 'wallet_type']
                ];
            case 'fetchDetails':
                return [
                    'queryParams' => ['mobile', 'wallet_type']
                ];
            default:
                return [];
        }
    }

    public static function link(array $body): array
    {
        $uri = self::getResourceUri() . '/bind';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    public static function unlink(array $body): array
    {
        $uri = self::getResourceUri() . '/unbind';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    public static function fetchDetails(array $queryParams) {
        $options = ['queryParams' => $queryParams];
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', self::getResourceUri(), $options);
        return json_decode($resBody, true);
    }
}
