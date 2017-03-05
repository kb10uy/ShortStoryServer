<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utilities\TextParser;

class TextServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('text', function ($app) {
            return new TextParser;
        });
    }
}
