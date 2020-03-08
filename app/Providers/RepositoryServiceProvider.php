<?php

namespace App\Providers;

use App\Infrastructure\Contracts\IMemoryRepository;
use App\Infrastructure\Repositories\RedisMemoryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IMemoryRepository::class,
            RedisMemoryRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
