<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\RefreshToken;
use App\Http\Controllers\JwtController;
use Throwable;

class RefreshTokensController extends Controller
{
    public static function insert($token) {
        try {
            $payload = JwtController::decode_jwt($token);

            RefreshToken::create([
                'email' => $payload->email,
                'token' => $token,
                'revoked' => FALSE,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Refresh token created.'
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }

    public static function get($token) {
        try {
            return RefreshToken::where('token', $token)->first();
        } catch (Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred'
            ]);
        }
    }
}
