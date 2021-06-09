<?php

namespace App\Providers;

use App\Services\OrganisationService;
use App\Services\OrganisationServiceContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrganisationServiceContract::class,
            function ($app) {
                return new OrganisationService(); // hardcoded, maybe more logic can be here :)
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
