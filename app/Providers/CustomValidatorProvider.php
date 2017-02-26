<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class CustomValidatorProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //設定されたNGワードでないか
        Validator::extend('allowed', function ($attr, $value, $params, $vtor) {
            return in_array($value, config('validator.prohibit'));
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
