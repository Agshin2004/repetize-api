<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // This will throw if token is missing or invalid
            $user = JWTAuth::parseToken()->authenticate();
            if ($user) {
                return response()->json(['message' => 'Already authenticated.'], 403);
            }
        } catch (\Exception $e) {

        }
        return $next($request);
    }
}
