<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Http\Resources\Json\Resource;
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
        Resource::withoutWrapping();

        Response::macro('jsonError', function($message, $code) {
            return response()->json(['error' => $message], $code);
        });
        Response::macro('jsonResult', function($message, $code) {
            return response()->json(['result' => $message], $code);
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
