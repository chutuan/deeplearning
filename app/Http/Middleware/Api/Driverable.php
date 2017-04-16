<?php

namespace App\Http\Middleware\Api;

use Closure;

class Driverable
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
        if (!\Auth::user() || \Auth::user() && !\Auth::user()->isDriver()) {
            return \Response::json([
                'success' => false,
                'status' => 406,
                'message' => 'You don\'t have permission',
                'data' => null
            ]);
        }

        return $next($request);
    }
}
