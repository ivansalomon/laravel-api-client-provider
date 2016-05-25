<?php
namespace Triadev\LaravelApiClientProvider\Exception;

/**
 * Class ApiClientHttpMethodException
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Exception
 */
class ApiClientHttpMethodException extends \Exception
{
    public function __construct($invalid_http_method, array $valid_http_methods)
    {
        $valid_http_methods = implode(', ', $valid_http_methods);

        parent::__construct("Invalid http method: {$invalid_http_method} | (Valid http methods: {$valid_http_methods})");
    }
}