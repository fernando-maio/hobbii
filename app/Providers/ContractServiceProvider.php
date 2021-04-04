<?php

namespace App\Providers;

use App\Contracts\Services\ActionServiceInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Contracts\Services\ProjectServiceInterface;
use App\Services\ActionService;
use App\Services\ClientService;
use App\Services\ProjectService;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Register services. Bind Services Interfaces.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClientServiceInterface::class,
            ClientService::class
        );

        $this->app->bind(
            ProjectServiceInterface::class,
            ProjectService::class
        );

        $this->app->bind(
            ActionServiceInterface::class,
            ActionService::class
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
