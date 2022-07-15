<?php

namespace Durianpay\Http;

use Durianpay\Http\GuzzleRequestor as GuzzleRequestor;

/**
 * ApiClient Class
 * 
 * @category Class
 */
class ApiClient
{
    /**
     * Main function to send HTTP requests through Guzzle object
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $options
     *
     * @return array
     */
    public static function sendRequest(string $method, string $uri, $options = []): array
    {
        return GuzzleRequestor::getInstance()->request($method, $uri, $options);
    }

    /**
     * Validate request options/payload before being sent to the APIs
     *
     * @param  array $options
     * @param  array $requiredOptions
     */
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

    /**
     * To validate POST requests' body object
     *
     * @param  array $body
     * @param  array $reqBody
     */
    private static function _isRequestBodyValid(array $body, array $reqBody)
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
}
