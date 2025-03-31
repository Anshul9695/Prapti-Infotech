<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
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
        if (!session()->has('loggedinUser') && ($request->path() != '/login')) {
            return redirect('login');
        }
        if (session()->has('LoggedInUser') && ($request->path() == '/login')) {
            return redirect()->back();
        }
        return $next($request);
    }
}
