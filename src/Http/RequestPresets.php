<?php

namespace Durianpay\Http;

trait RequestPresets
{
    public static function create(array $body)
    {
        $uri = static::getResourceUri();
        $options = ['body' => $body];

        $res = GuzzleClient::getInstance()->request('POST', $uri, $options);
        return json_decode($res[0], true);
    }

    public static function fetch(array $queryParams)
    {
        $uri = static::getResourceUri();
        $options = ['queryParams' => $queryParams];

        $res = GuzzleClient::getInstance()->request('GET', $uri, $options);
        return json_decode($res[0], true);
    }
}
