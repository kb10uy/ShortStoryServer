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
        // 設定されたNGワードでないか
        Validator::extend('allowed', function ($attr, $value, $params, $vtor) {
            return !in_array($value, config('validator.prohibited'));
        });
        // <識別子>に使える文字列か
        Validator::extend('str_ident', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\w\d\-]+$/u', $value) !== FALSE;
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
