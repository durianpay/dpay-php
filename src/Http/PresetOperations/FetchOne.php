<?php

namespace Durianpay\Http\PresetOperations;

trait FetchOne
{
    public static function fetchOne(string $id, array $queryParams = [])
    {
        $uri = static::getResourceUri() . '/' . $id;
        $options = ['queryParams' => $queryParams];

        \Durianpay\Http\ApiClient::validateRequestOptions($options, static::getRequiredOptions('fetchOne'));

        $res = \Durianpay\Http\GuzzleClient::getInstance()->request('GET', $uri, $options);
        return json_decode($res[0], true);
    }
}
