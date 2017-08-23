<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use App\Utilities\MeCabEngine;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        resolve(EngineManager::class)->extend('mecab', function () {
            return new MeCabEngine;
        });

        Validator::extend('str_ident', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\w\d\-]+$/u', $value) !== FALSE;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
