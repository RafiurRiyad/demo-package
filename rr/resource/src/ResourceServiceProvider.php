<?php

namespace rr\resource;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('rr\resource\ResourceController');
        $this->app->make('rr\resource\ResourceRequest');
        $this->app->make('rr\resource\Resource');
        $this->loadViewsFrom(__DIR__ . '/views', 'resource');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')
            ->group(function () {
                Route::resource('/resource', 'ResourceController');
            });

        $this->loadMigrationsFrom(__DIR__ .
            '/database/migrations');
    }

    private function createCustomTable()
    {
        // Generate a migration file
        $this->publishes([
            __DIR__ . '/../database/migrations/create_resources_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_resources_table.php'),
        ], 'migrations');
    }
}
