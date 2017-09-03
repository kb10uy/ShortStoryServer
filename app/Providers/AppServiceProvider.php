<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use App\Utilities\MeCabEngine;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Response;

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

        Response::macro('jsonError', function($messageId, $code) {
            return response()->json(['error' => __($messageId)], $code);
        });
        Response::macro('jsonResult', function($messageId, $code) {
            return response()->json(['result' => __($messageId)], $code);
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
