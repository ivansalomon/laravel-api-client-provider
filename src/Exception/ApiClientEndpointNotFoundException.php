<?php
namespace Triadev\LaravelApiClientProvider\Exception;

/**
 * Class ApiClientEndpointNotFoundException
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Exception
 */
class ApiClientEndpointNotFoundException extends \Exception
{
    public function __construct($endpoint)
    {
        parent::__construct("Endpoint not found: {$endpoint}");
    }
}