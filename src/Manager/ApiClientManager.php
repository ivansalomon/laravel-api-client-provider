<?php
namespace Triadev\LaravelApiClientProvider\Manager;

use Triadev\LaravelApiClientProvider\Client\AbstractApiClient;
use Triadev\LaravelApiClientProvider\Client\AbstractApiClientFacade;
use Triadev\LaravelApiClientProvider\Contract\ApiClientManagerContract;
use Triadev\LaravelApiClientProvider\Exception\ApiClientNotFoundException;
use Triadev\LaravelApiClientProvider\Exception\ApiClientValidationException;
use Illuminate\Foundation\Application;

/**
 * Class ApiClientManager
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Manager
 */
class ApiClientManager implements ApiClientManagerContract
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $clients = [];

    /**
     * @var array
     */
    private $clients_facades = [];

    /**
     * ApiClientManager constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = $app['config']['laravelapiclient'];
    }

    /**
     * Get client
     *
     * @param string $client
     * @return AbstractApiClient
     * @throws ApiClientNotFoundException
     */
    public function getClient($client)
    {
        if(!array_key_exists($client, $this->config['clients'])){
            throw new ApiClientNotFoundException($client);
        }

        if(!array_key_exists($client, $this->clients)){
            $namespace = $this->config['namespace']['api_client'] . '\\' . $client . 'ApiClient';
            $config = $this->config['clients'][$client];

            /**
             * Validation
             */
            $this->_validateApiClientConfig($client, $config, $this->config['validation']);

            $this->clients[$client] = new $namespace($config);
        }
        return $this->clients[$client];
    }

    /**
     * Get client facade
     *
     * @param string $client
     * @return AbstractApiClientFacade
     * @throws ApiClientNotFoundException
     */
    public function getClientFacade($client)
    {
        if(!array_key_exists($client, $this->clients_facades)){

            try{
                $api_client = $this->getClient($client);
            } catch (ApiClientNotFoundException $e){
                throw $e;
            }

            $namespace = $this->config['namespace']['api_client_facade'] . '\\' . $client . 'ApiClientFacade';

            $this->clients_facades[$client] = new $namespace($api_client);
        }
        return $this->clients_facades[$client];
    }

    /**
     * Validate api client config
     *
     * @param string $client
     * @param array $config
     * @param array $validation
     * @throws ApiClientValidationException
     */
    private function _validateApiClientConfig($client, array $config, array $validation){
        $validate = true;
        $invalid_key = '';

        foreach ($validation as $key){
            if(!array_key_exists($key, $config)){
                $validate = false;
                $invalid_key = $key;
                break;
            }
        }

        if(!$validate){
            throw new ApiClientValidationException($client, $invalid_key);
        }
    }
}