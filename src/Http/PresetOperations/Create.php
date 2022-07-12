<?php

namespace Durianpay\Http\PresetOperations;

trait Create
{
    public static function create(array $body)
    {
        $uri = static::getResourceUri();
        $options = ['body' => $body];

        \Durianpay\Http\ApiClient::validateRequestOptions($options, static::getRequiredOptions('create'));

        $res = \Durianpay\Http\GuzzleClient::getInstance()->request('POST', $uri, $options);
        return json_decode($res[0], true);
    }
}
