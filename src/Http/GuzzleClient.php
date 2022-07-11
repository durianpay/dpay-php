<?php

namespace Durianpay\Http;

use GuzzleHttp\Client as GuzzleClientObject;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Durianpay\Durianpay as Durianpay;
use Durianpay\Config as Config;

class GuzzleClient
{
    private static $_instance;
    private $_httpClient;

    private function __construct()
    {
        $this->_httpClient = new GuzzleClientObject(
            [
                'base_uri' => Config::$baseUrl,
                'timeout' => Config::$defaultTimeout
            ]
        );
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function _getCompleteUri(string $uri, array $options): string | array
    {
        if (array_key_exists('pathParams', $options) && count($options['pathParams']) > 0) return [$uri, $options['pathParams']];
        return $uri;
    }

    private function _setDefaultHeaders(array $options): array
    {
        $defaultHeaders = [
            'Content-Type' => 'application/json'
        ];

        if (!array_key_exists('headers', $options)) return $defaultHeaders;
        return array_merge($options['headers'], $defaultHeaders);
    }

    private function _validateRequestOptions(array $options): array
    {
        $reqAuth = Durianpay::getApiKey();
        $reqHeaders = $this->_setDefaultHeaders($options);

        $reqOptions = [
            GuzzleRequestOptions::HEADERS => $reqHeaders,
            GuzzleRequestOptions::AUTH => [$reqAuth, '']
        ];

        if (array_key_exists('body', $options) && count($options['body']) > 0) {
            $reqOptions += [GuzzleRequestOptions::JSON => $options['body']];
        }
        if (array_key_exists('queryParams', $options) && count($options['queryParams']) > 0) {
            $reqOptions += [GuzzleRequestOptions::QUERY => $options['queryParams']];
        }

        return $reqOptions;
    }

    public function request(string $uri, array $options)
    {
        $reqOptions = $this->_validateRequestOptions($options);
        $reqUri = $this->_getCompleteUri($uri, $options);
        $reqMethod = strtoupper($options['method']);

        try {
            $response = $this->_httpClient->request($reqMethod, $reqUri, $reqOptions);
        } catch (GuzzleRequestException $err) {
            $errResponse = $err->getResponse();

            $errBody = json_decode($errResponse->getBody()->getContents(), true);
            $errCode = $errResponse->getStatusCode();
            $errHeader = $errResponse->getHeaders();

            var_dump($errResponse);
        }

        return [(string)$response->getBody(), $response->getStatusCode(), $response->getHeaders()];
    }
}
