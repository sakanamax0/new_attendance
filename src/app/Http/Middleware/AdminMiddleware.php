<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->is_admin) {
            return $next($request); 
        }

        return redirect('/admin/login'); 
    }
}
