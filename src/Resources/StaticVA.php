<?php

namespace Durianpay\Resources;

use Durianpay\Config as Config;
use Durianpay\Exceptions\EnvironmentException as EnvironmentException;

/**
 * Static Virtual Account Class
 * 
 * @category Class
 * @link https://durianpay.id/docs/api/static-virtual-account/overview/
 */
class StaticVA implements ResourceInterface
{
    use \Durianpay\Http\PresetOperations\Create;
    use \Durianpay\Http\PresetOperations\Fetch;
    use \Durianpay\Http\PresetOperations\FetchOne;

    /**
     * Retrieve static virtual account APIs' base uri
     *
     * @return string
     */
    public static function getResourceUri(): string
    {
        return 'payments/va/static';
    }

    /**
     * Retrieve required options for a specific static virtual account API 
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
                        'bank_code',
                        'name',
                        'is_closed',
                        'amount',
                        'customer' => [
                            'given_name', 'email', 'mobile', 'id'
                        ],
                        'expiry_minutes',
                        'account_number'
                    ]
                ];
            case 'update':
                return [
                    'body' => ['expiry_minutes']
                ];
            default:
                return [];
        }
    }

    /**
     * Update a single static virtual account
     *
     * @param  string $id
     * @param  array  $body
     *
     * @return array
     */
    public static function update(string $id, array $body): array
    {
        $uri = self::getResourceUri() . '/' . $id;
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('PATCH', $uri, $options);
        return json_decode($resBody, true);
    }

    /**
     * Simulate static virtual account in Sandbox mode
     *
     * @param  array $body
     *
     * @return array
     * 
     * @throws EnvironmentException
     */
    public static function simulate(array $body): array
    {
        $env = Config::$environment;
        if ($env === 'production') {
            throw new EnvironmentException("Feature is not supported in" . $env . " mode", $env);
        }

        $uri = self::getResourceUri() . '/simulate';
        $options = ['body' => $body];

        [$resBody, $resCode, $resHeaders] = \Durianpay\Http\ApiClient::sendRequest('POST', $uri, $options);
        return json_decode($resBody, true);
    }
}
