<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class CustomBladeDirectiveProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //nullable($value, $key) directive
        Blade::directive('nullable', function ($expression) {
            $params = eval('return [' . substr($expression, 1, -1) . '];');
            
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
