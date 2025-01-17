<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\JwtController;

class JwtValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        try {
            $payload = JwtController::decode_jwt($token);

            $token_has_expired = strtotime('now') >= $payload->exp;
            
            if (
                $payload->type != 'access_token'
                || $token_has_expired
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User is unauthenticated or token is invalid.',
                    'url' => 'home'
                ], 401);
            }

            return $next($request);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'User is unauthenticated or token is invalid.',
                'url' => 'home'
            ], 401);
        }
    }
}
