<?php

namespace Durianpay\Http;

use GuzzleHttp\Client as GuzzleClientObject;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Durianpay\Durianpay as Durianpay;
use Durianpay\Config as Config;
use Durianpay\Exceptions\BadRequestException as BadRequestException;

/**
 * GuzzleRequestor Class
 * 
 * @category Class
 */
class GuzzleRequestor
{
    private static $_instance;
    private $_httpClient;

    /**
     * GuzzleRequestor class constructor
     */
    private function __construct()
    {
        $this->_httpClient = new GuzzleClientObject(
            [
                'base_uri' => Config::$baseUrl,
                'timeout' => Config::$defaultTimeout
            ]
        );
    }

    /**
     * To create an instance of this class
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Process headers object and set up default values for it
     *
     * @param  array $options
     *
     * @return array
     */
    private function _setDefaultHeaders(array $options): array
    {
        $defaultHeaders = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        if (!array_key_exists('headers', $options)) return $defaultHeaders;
        return array_merge($options['headers'], $defaultHeaders);
    }

    /**
     * To process options before being sent through Guzzle HTTP request
     *
     * @param  array $options
     *
     * @return array
     */
    private function _processRequestOptions(array $options): array
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

    /**
     * Error handler if HTTP request results in error
     *
     * @param  array   $errorBody
     * @param  integer $errorCode
     * 
     * @throws BadRequestException
     */
    private function _handleError(array $errorBody, int $errorCode): void
    {
        [
            'error' => $errorMessage,
            'error_code' => $errorStateCode,
        ] = $errorBody;

        $errorDesc = [];
        if (array_key_exists('errors', $errorBody)) {
            $errorDesc = $errorBody['errors'];
        }

        throw new BadRequestException($errorMessage, $errorCode, $errorStateCode, $errorDesc);
    }
    
    /**
     * To send HTTP requests to Durianpay APIs
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $options
     */
    public function request(string $method, string $uri, array $options)
    {
        $reqOptions = $this->_processRequestOptions($options);
        $reqMethod = strtoupper($method);

        try {
            $response = $this->_httpClient->request($reqMethod, $uri, $reqOptions);
        } catch (GuzzleRequestException $err) {
            $errResponse = $err->getResponse();
            $errBody = json_decode($errResponse->getBody()->getContents(), true);
            $errCode = $errResponse->getStatusCode();

            $this->_handleError($errBody, $errCode);
        }

        return [(string)$response->getBody(), $response->getStatusCode(), $response->getHeaders()];
    }
}
