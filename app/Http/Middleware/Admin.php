<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {        
        if (Auth::check() && Auth::user()->is_admin === 1) {
            return $next($request);
        } 
        Auth::logout();
        return redirect()->route('login')->withErrors('Incorrect username or password.');
    }
}