<?php

namespace Durianpay\Http\PresetOperations;

/**
 * Delete Trait
 * 
 * @category Trait
 */
trait Delete
{
    /**
     * A reusable trait function that can be used to erase a single data from a designated feature
     *
     * @param  string $id
     * 
     * @return array
     */
    public static function delete(string $id): array
    {
        $uri = static::getResourceUri() . '/' . $id;

        $res = \Durianpay\Http\GuzzleRequestor::getInstance()->request('DELETE', $uri, []);
        return json_decode($res[0], true);
    }
}
