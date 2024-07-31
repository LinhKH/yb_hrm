<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class EmployeeAuth
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

        //echo session()->get('employee_id');  ;

        $path = $request->path();


        if (($path == "employee/login") && Session::get('employee')) {
            return redirect('/employee/home');
        } else if ($path != 'employee/login' && !Session::get('employee')) {
            return redirect('employee/login');
        }

        return $next($request);
    }
}
