<?php

namespace Durianpay\Resources;

/**
 * Ewallet Account Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/ewallet/link/
 */
class EwalletAccount implements ResourceInterface
{
    /**
     * Retrieve ewallet account APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'ewallet/account';
    }

    /**
     * Retrieve required options for a specific ewallet account API 
     *
     * @param  string $api
     *
     * @return array
     */ 
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

    /**
     * Link ewallet account to Durianpay
     *
     * @param  array $body
     *
     * @return array
     */
    public static function link(array $body): array
    {
        $uri = self::getResourceUri() . '/bind';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Unlink linked ewallet account from Durianpay
     *
     * @param  array $body
     *
     * @return array
     */
    public static function unlink(array $body): array
    {
        $uri = self::getResourceUri() . '/unbind';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Fetch details of a single linked ewallet account
     *
     * @param  array $queryParams
     */
    public static function fetchDetails(array $queryParams) {
        $options = ['queryParams' => $queryParams];
        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', self::getResourceUri(), $options);
        return json_decode($resBody, true);
    }
}
