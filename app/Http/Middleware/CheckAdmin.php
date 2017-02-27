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
        if (Auth::user()->type != 'admin') {
            Session::flash('alert', __('view.message.not_admin'));
            return redirect()->route('home');
        }
        return $next($request);
    }
}