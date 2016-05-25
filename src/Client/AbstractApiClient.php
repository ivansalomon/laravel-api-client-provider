<?php
namespace Triadev\LaravelApiClientProvider\Client;

use Triadev\LaravelApiClientProvider\Exception\LaravelApiClientEndpointNotFoundException;
use Triadev\LaravelApiClientProvider\Exception\LaravelApiClientHttpMethodException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class AbstractApiClient
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Client
 */
abstract class AbstractApiClient
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';

    const DATA_TYPE_JSON = 'JSON';
    const DATA_TYPE_FORM = 'FORM';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $base_uri;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $response_headers = [];

    /**
     * @var int
     */
    private $response_status_code;

    /**
     * @var string
     */
    private $response_reason_phrase;

    /**
     * @var array
     */
    private $endpoints = [];

    /**
     * AbstractApiClient constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = []){
        $this->config = $config;
        $this->client = new Client();

        /**
         * Base uri
         */
        $this->_createBaseUri();

        /**
         * Headers
         */
        if(array_key_exists('headers', $this->config)){
            $this->headers = $this->config['headers'];
        }

        /**
         * Endpoints
         */
        if(array_key_exists('endpoints', $this->config)){
            $this->endpoints = $this->config['endpoints'];
        }
    }

    /**
     * Create base uri
     */
    private function _createBaseUri(){
        $this->base_uri = '';

        /**
         * Scheme
         */
        if(in_array($this->config['scheme'], ['http', 'https'])){
            $this->base_uri .= $this->config['scheme'] . '://';
        }

        /**
         * Url
         */
        $this->base_uri .= $this->config['url'];

        /**
         * Port
         */
        if(array_key_exists('port', $this->config)){
            $this->base_uri .= '::' . $this->config['port'];
        }
    }

    /**
     * Generate endpoint
     *
     * @param string $endpoint
     * @param array $params
     * @return string
     * @throws LaravelApiClientEndpointNotFoundException
     */
    private function _generateEndpoint($endpoint, array $params = []){
        if(!array_key_exists($endpoint, $this->endpoints)){
            throw new LaravelApiClientEndpointNotFoundException($endpoint);
        }

        $endpoint = $this->endpoints[$endpoint];

        $endpoint_elements = explode('/', $endpoint);
        foreach ($endpoint_elements as $element){
            if($element != null){
                if(preg_match('/^{(?<param>[a-zA-Z0-9\_\-]+)}$/', $element, $matches)){
                    if(array_key_exists($matches['param'], $params)){
                        $endpoint = str_replace("{{$matches['param']}}",  $params[$matches['param']], $endpoint);
                    }
                }
            }
        }

        return $endpoint;
    }

    /**
     * Get config param
     *
     * @param string $key
     * @return string|array
     */
    public function getConfigParam($key){
        if(array_key_exists($key, $this->config)){
            return $this->config[$key];
        }

        return null;
    }

    /**
     * Add header
     *
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value){
        if(!array_key_exists($key, $this->headers)){
            $this->headers[$key] = $value;
        }
    }

    /**
     * Get response header
     *
     * @param string $key
     * @return array
     */
    public function getResponseHeader($key){
        if(array_key_exists($key, $this->response_headers)){
            return $this->response_headers[$key];
        }

        return null;
    }

    /**
     * Get response status code
     *
     * @return int
     */
    public function getResponseStatusCode(){
        return $this->response_status_code;
    }

    /**
     * Request
     *
     * @param string $endpoint
     * @param string $http_method
     * @param array $params
     * @param array $query_params
     * @param array $headers
     * @param array|null $data
     * @param string $data_type
     *
     * @return string
     * @throws LaravelApiClientHttpMethodException
     */
    protected function request(
        $endpoint,
        $http_method,
        array $params = [],
        array $query_params = [],
        array $headers = [],
        array $data = [],
        $data_type = self::DATA_TYPE_JSON)
    {
        $valid_http_methods = ['GET', 'POST', 'PUT', 'DELETE'];
        if(!in_array($http_method, $valid_http_methods)){
            throw new LaravelApiClientHttpMethodException($http_method, $valid_http_methods);
        }

        /**
         * Endpoint
         */
        $endpoint = $this->base_uri . '/' . $this->_generateEndpoint($endpoint, $params);

        /**
         * Query
         */
        $query = '';
        foreach ($query_params as $query_key => $query_value){
            if($query == ''){
                $query .= '?';
            }
            else{
                $query .= '&';
            }

            $query .= $query_key . '=' . $query_value;
        }
        $endpoint .= $query;

        /**
         * Data
         */
        if($data){
            if($data_type == self::DATA_TYPE_JSON){
                $data = json_encode($data);
                $headers['Content-Type'] = 'application/json';
            }
            else if($data_type == self::DATA_TYPE_FORM){
                $data = http_build_query($data, null, '&');
                $headers['Content-Type'] = 'application/x-www-form-urlencoded';
            }
        }

        /** @var Request $request */
        $request = new Request($http_method, $endpoint, array_merge($this->headers, $headers), $data);

        /** @var Response $response */
        $response = $this->client->send($request);
        $this->response_headers = $response->getHeaders();
        $this->response_status_code = $response->getStatusCode();
        $this->response_reason_phrase = $response->getReasonPhrase();

        return json_decode($response->getBody()->getContents());
    }
}