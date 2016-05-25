<?php
namespace Triadev\LaravelApiClientProvider;

use Triadev\LaravelApiClientProvider\Contract\ApiClientContract;
use Triadev\LaravelApiClientProvider\Manager\ApiClientManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApiClientServiceProvider
 *
 * @author Christopher Lorke <christopher.lorke@gmx.de>
 * @package Triadev\LaravelApiClientProvider
 */
class ApiClientServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiClientContract::class, function(Application $application){
            return new ApiClientManager($application);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/config.php' => config_path('laravelapiclient.php'),
        ], 'config');
    }
}