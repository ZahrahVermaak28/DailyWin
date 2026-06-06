<?php

namespace App\Providers;

use App\Repositories\EloquentTaskRepositoryAZU;
use App\Repositories\TaskRepositoryAZU;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProviderAZU extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaskRepositoryAZU::class,
            EloquentTaskRepositoryAZU::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
