<?php

namespace Core\Infrastructure\ServiceProviders;

use Core\Domain\Repository\ChannelRepositoryInterface;
use Core\Domain\Repository\MessageRepositoryInterface;
use Core\Persistence\Repository\ChannelRepository;
use Core\Persistence\Repository\MessageRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
            ChannelRepositoryInterface::class,
            ChannelRepository::class
        );

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );
    }
}
