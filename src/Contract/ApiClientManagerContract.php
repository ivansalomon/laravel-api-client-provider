<?php
namespace Triadev\LaravelApiClientProvider\Contract;

use Triadev\LaravelApiClientProvider\Client\AbstractApiClient;
use Triadev\LaravelApiClientProvider\Client\AbstractApiClientFacade;

/**
 * Interface ApiClientManagerContract
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Contract
 */
interface ApiClientManagerContract
{
    /**
     * Get client
     *
     * @param string $client
     * @return AbstractApiClient
     */
    public function getClient($client);

    /**
     * Get client facade
     *
     * @param $client
     * @return AbstractApiClientFacade
     */
    public function getClientFacade($client);
}