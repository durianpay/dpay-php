<?php

namespace Durianpay\Http\PresetOperations;

trait Delete
{
    public static function delete(string $id)
    {
        $uri = static::getResourceUri() . '/' . $id;

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('DELETE', $uri, []);
        return json_decode($res[0], true);
    }
}
