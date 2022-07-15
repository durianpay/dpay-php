<?php

namespace Durianpay\Http\PresetOperations;

trait FetchOne
{
    public static function fetchOne(string $id, array $queryParams = [])
    {
        $uri = static::getResourceUri() . '/' . $id;
        $options = ['queryParams' => $queryParams];

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('GET', $uri, $options);
        return json_decode($res[0], true);
    }
}
