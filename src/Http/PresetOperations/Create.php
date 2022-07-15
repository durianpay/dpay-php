<?php

namespace Durianpay\Http\PresetOperations;

trait Create
{
    public static function create(array $body)
    {
        $uri = static::getResourceUri();
        $options = ['body' => $body];

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('POST', $uri, $options);
        return json_decode($res[0], true);
    }
}
