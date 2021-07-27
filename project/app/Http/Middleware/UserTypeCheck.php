<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserTypeCheck
{
    /**
     * Checking user type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return (auth()->user()->type == "manager") ? $next($request) : response("Access denied!", 401);
    }
}
