<?php

namespace Bregananta\Anteraja;

use Illuminate\Support\ServiceProvider;

class AnterajaBaseServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/anteraja.php', 'anteraja-config');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/anteraja.php' => config_path('anteraja.php'),
            ], 'anteraja-config');

        }
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind('Anteraja', function ($app) {
            return new \Bregananta\Anteraja\Anteraja();
        });
    }
}