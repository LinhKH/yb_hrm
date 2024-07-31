<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class AdminAuth
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

        $path = $request->path();
        if (($path == "/") && Session::get('admin')) {
            return redirect('/admin/dashboard');
        } else if (($path != '/') && (!Session::get('admin'))) {
            return redirect('/');
        }

        return $next($request);
    }
}
