<?php
namespace Triadev\LaravelApiClientProvider\Exception;

/**
 * Class ApiClientValidationException
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Exception
 */
class ApiClientValidationException extends \Exception
{
    public function __construct($client, $key)
    {
        parent::__construct("Invalid api client config {$client}: {$key}");
    }
}