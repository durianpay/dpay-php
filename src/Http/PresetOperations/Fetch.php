<?php

namespace Durianpay\Http\PresetOperations;

/**
 * Fetch Trait
 * 
 * @category Trait
 */
trait Fetch
{
    /**
     * A reusable trait function that can be used to retrieve multiple data from a designated feature
     *
     * @param  array $queryParams
     *
     * @return array
     */
    public static function fetch(array $queryParams = []): array
    {
        $uri = static::getResourceUri();

        if (!array_key_exists('limit', $queryParams)) {
            $queryParams['limit'] = 5;
        }
        $options = ['queryParams' => $queryParams];

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('GET', $uri, $options);
        return json_decode($res[0], true);
    }
}
