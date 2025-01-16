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
            JwtController::decode_jwt($token);
            return $next($request);
        } catch (\Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'User is unauthenticated.',
                'url' => 'home'
            ]);
        }
    }
}
