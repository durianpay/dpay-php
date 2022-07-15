<?php

namespace Durianpay\Http\PresetOperations;

/**
 * FetchOne Trait
 * 
 * @category Trait
 */
trait FetchOne
{
    /**
     * A reusable trait function that can be used to retrieve a single data from a designated feature
     *
     * @param  string $id
     * @param  array  $queryParams
     * 
     * @return array
     */
    public static function fetchOne(string $id, array $queryParams = []): array
    {
        $uri = static::getResourceUri() . '/' . $id;
        $options = ['queryParams' => $queryParams];

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('GET', $uri, $options);
        return json_decode($res[0], true);
    }
}
