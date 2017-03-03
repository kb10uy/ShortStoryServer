<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class CheckAdmin
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
        if (Auth::user()->type == 'admin') {
            return $next($request);
        } else if (Auth::guard('web')->check()) {
            // Web
            Session::flash('alert', __('view.message.not_admin'));
            return redirect()->route('home');
        } else {
            // API
            return response()->json([
                'error' => 'You don\'t have admin previlage.', 
            ], 403);
        }
    }
}