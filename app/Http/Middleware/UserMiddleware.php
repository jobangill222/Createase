<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserMiddleware
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
        try {
            // $user = JWTAuth::parseToken()->authenticate();
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                // throw new \Exception('User not found');
                return response()->json(['status' => 'error', 'message' => 'un-authenticated'], 401);
            }
        } catch (\Exception $e) {
            // Token is invalid or not provided, or user not found
            return response()->json(['status' => 'error', 'message' => 'un-authenticated'], 401);
        }

        // User is authenticated, proceed with the request
        return $next($request);

    }
}
