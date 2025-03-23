<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class JwtRefreshMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            if (!$refreshToken) {
                return response()->json(['error' => 'Refresh token not found'], Response::HTTP_UNAUTHORIZED);
            }

            JWTAuth::setToken($refreshToken);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json(['error' => 'Invalid refresh token'], Response::HTTP_UNAUTHORIZED);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Refresh token is invalid or expired'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
