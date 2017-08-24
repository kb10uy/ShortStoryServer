<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (App::isDownForMaintenance()) {
            $ip = $request->getClientIp();
            if (!preg_match(env('DEVELOP_IP'), $ip)) {
                $data = json_decode(file_get_contents(App::storagePath().'/framework/down'), true);
                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
            }
        }
        return $next($request);
    }
}
