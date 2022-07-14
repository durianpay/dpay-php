<?php

namespace Durianpay\Http;

use Durianpay\Http\GuzzleClient as GuzzleClient;

class ApiClient
{
    public static function sendRequest($method, $uri, $options = []): array
    {
        return GuzzleClient::getInstance()->request($method, $uri, $options);
    }

    public static function validateRequestOptions(array $options, array $requiredOptions)
    {
        if (array_key_exists('body', $options) && array_key_exists('body', $requiredOptions)) {
            $body = $options['body'];
            $reqBody = $requiredOptions['body'];

            if (!self::_isRequestBodyValid($body, $reqBody)) {
                $message = "You must include required properties in your request body! Check https://durianpay.id/docs/api/ for detailed documentation.\n";
                throw new \InvalidArgumentException($message);
            }
        } else if (array_key_exists('queryParams', $options) && array_key_exists('queryParams', $requiredOptions)) {
            $qryParams = $options['queryParams'];
            $reqQryParams = $requiredOptions['queryParams'];

            $qryParamsDiff = array_diff_key(array_flip($reqQryParams), $qryParams);
            if (count($qryParamsDiff) > 0) {
                $message = "You must include required properties in your query parameters! Check https://durianpay.id/docs/api/ for detailed documentation.\n";
                throw new \InvalidArgumentException($message);
            }
        } else if (array_key_exists('headers', $options) && array_key_exists('headers', $requiredOptions)) {
            $headers = $options['headers'];
            $reqHeaders = $requiredOptions['headers'];

            $headersDiff = array_diff_key(array_flip($reqHeaders), $headers);
            if (count($headersDiff) > 0) {
                $message = "You must include required headers! Check https://durianpay.id/docs/api/ for detailed documentation.\n";
                throw new \InvalidArgumentException($message);
            }
        }
    }

    private static function _isRequestBodyValid($body, $reqBody)
    {
        foreach ($reqBody as $key => $value) {
            if (is_int($key)) {
                $key = $value;
                $value = null;
            }

            // Check if the required property exists in request body
            if (!array_key_exists($key, $body)) return false;

            // Check if there is subarray that needs to be validated
            if (is_array($value)) {
                if (self::_isRequestBodyValid($body[$key], $value) === false) return false;
            }
        }
        return true;
    }

    private static function _isNull($val)
    {
        if ($val === null) return true;
        if (is_int($val)) return ($val === 0);
        if (is_string($val)) return trim($val) === '';
        return false;
    }
}
