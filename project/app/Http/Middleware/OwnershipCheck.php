<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnershipCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        return (auth()->user()->id == $request->order->user_id) ? $next($request) : response("This is not one of your orders!", 401);

    }
}
