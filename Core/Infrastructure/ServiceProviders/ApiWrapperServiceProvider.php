<?php

namespace Core\Infrastructure\ServiceProviders;

use Core\Domain\ApiWrappers\CurlApiInterface;
use Core\Domain\ApiWrappers\EmailApiInterface;
use Core\Infrastructure\ApiWrappers\CurlApi;
use Core\Infrastructure\ApiWrappers\EmailApi;
use Illuminate\Support\ServiceProvider;

class ApiWrapperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CurlApiInterface::class,
            CurlApi::class
        );

        $this->app->bind(
            EmailApiInterface::class,
            EmailApi::class
        );
    }
}
