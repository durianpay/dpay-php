<?php

namespace Durianpay\Http\PresetOperations;

/**
 * Create Trait
 * 
 * @category Trait
 */
trait Create
{
    /**
     * A reusable trait function that can be used to create a single data from a designated feature
     *
     * @param  array $body
     *
     * @return array
     */
    public static function create(array $body): array
    {
        $uri = static::getResourceUri();
        $options = ['body' => $body];

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('POST', $uri, $options);
        return json_decode($res[0], true);
    }
}
