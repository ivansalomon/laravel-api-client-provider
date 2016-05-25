<?php
namespace Triadev\LaravelApiClientProvider\Client;

/**
 * Class AbstractApiClientFacade
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Client
 */
abstract class AbstractApiClientFacade
{
    /**
     * @var AbstractApiClient
     */
    private $client;

    /**
     * AbstractApiClientFacade constructor.
     *
     * @param AbstractApiClient $client
     */
    public function __construct(AbstractApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return AbstractApiClient
     */
    protected function getClient(){
        return $this->client;
    }
}