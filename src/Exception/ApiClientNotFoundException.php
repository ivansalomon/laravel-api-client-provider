<?php
namespace Triadev\LaravelApiClientProvider\Exception;

/**
 * Class ApiClientNotFoundException
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Exception
 */
class ApiClientNotFoundException extends \Exception
{
    public function __construct($client)
    {
        parent::__construct("Client not found: {$client}");
    }
}