<?php
namespace Triadev\LaravelApiClientProvider\Contract;

use GuzzleHttp\Psr7\Response;

/**
 * Interface ApiClientContract
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Contract
 */
interface ApiClientContract
{
    /**
     * Request
     *
     * @param string $http_method
     * @param string $endpoint
     * @param string array $params
     * @param array $headers
     * @return Response
     */
    public function request($http_method, $endpoint, array $params = [], array $headers = []);
}