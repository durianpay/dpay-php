<?php

namespace Durianpay\Http\PresetOperations;

trait Fetch
{
    public static function fetch(array $queryParams = [])
    {
        $uri = static::getResourceUri();

        if (!array_key_exists('limit', $queryParams)) {
            $queryParams['limit'] = 5;
        }
        $options = ['queryParams' => $queryParams];

        \Durianpay\Http\ApiClient::validateRequestOptions($options, static::getRequiredOptions('fetch'));

        $res = \Durianpay\Http\GuzzleClient::getInstance()->request('GET', $uri, $options);
        return json_decode($res[0], true);
    }
}
