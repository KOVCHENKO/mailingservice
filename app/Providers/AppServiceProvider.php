<?php

namespace App\Providers;

use App\Core\Domain\Repository\ChannelRepositoryInterface;
use App\Core\Domain\Repository\MessageRepositoryInterface;
use App\Core\Persistence\Repository\ChannelRepository;
use App\Core\Persistence\Repository\MessageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
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
