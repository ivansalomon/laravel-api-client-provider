<?php
namespace Triadev\LaravelApiClientProvider\Facade;

use Triadev\LaravelApiClientProvider\Contract\ApiClientManagerContract;
use Illuminate\Support\Facades\Facade;

/**
 * Class ApiClientManagerFacade
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider\Facade
 */
class ApiClientManagerFacade extends Facade
{
    protected static function getFacadeAccessor() { return ApiClientManagerContract::class; }
}