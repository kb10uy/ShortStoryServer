<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use App\Utilities\MeCabEngine;
use Illuminate\Cookie\Middleware\EncryptCookies;
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
        $this->app->resolving(EncryptCookies::class, function ($object) {
            $object->disableFor('XDEBUG_SESSION');
        });
    }
}
