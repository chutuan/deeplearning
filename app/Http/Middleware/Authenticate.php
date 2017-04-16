<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $access_token = \Request::header('Authorization');
        $access_token = $access_token ?: "";
        $userRepository = new UserRepository(app());
        $user = $userRepository->findByField('access_token', $access_token)->first();
        if(!$user)
        {
            return \Response::json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }
        Auth::login($user);

        return $next($request);
    }
}
