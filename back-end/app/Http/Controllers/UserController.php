<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;

use App\Http\Controllers\JwtController;
use App\Http\Controllers\RefreshTokensController;
use Throwable;

class UserController extends Controller
{
    public function sign_up(Request $request) {
        try {
            User::create([
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'email_verified_at' => now(),
                'password' => Hash::make($request->get('password')),
                'remember_token' => Str::random(10),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'The user has been signed up.'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error has ocurred.'
            ]);
        }
    }
    
    public function login(Request $request) {
        $default_error = [
            'status' => 'error',
            'message' => 'The e-mail or the password are incorrect. Please, try again.'
        ];

        try {
            $user = User::where('email', '=', $request->get('email'))
                ->get()
            ->first();
            $user_not_found = empty($user);
            
            if ($user_not_found) {
                return response()->json($default_error);
            }

            $password_is_incorrect = !Hash::check($request->get('password'), $user->password);
            if ($password_is_incorrect) {
                return response()->json($default_error);
            }

            // $expiration_jwt = strtotime('+15 minutes');
            $expiration_jwt = strtotime('+30 seconds');

            $jwt = JwtController::generate_jwt([
                'name' => $user->name,
                'email' => $user->email,
                'exp' => $expiration_jwt,
                'type' => 'access_token'
            ]);

            // $expiration_refresh_token = strtotime('+2 days');
            $expiration_refresh_token = strtotime('+50 seconds');

            $refresh_token = JwtController::generate_jwt([
                'name' => $user->name,
                'email' => $user->email,
                'exp' => $expiration_refresh_token,
                'type' => 'refresh_token'
            ]);

            RefreshTokensController::insert($refresh_token);

            return response()->json([
                'status' => 'success',
                'message' => 'The authentication has succeded',
                'access_token' => $jwt,
                'refresh_token' => $refresh_token
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }

    // tokens handlers
    public function generate_access_token(Request $request) {
        try {
            $refresh_token = $request->get('refresh_token');

            $refresh_token_is_revoked = RefreshTokensController::get($refresh_token)->revoked == TRUE;
            if ($refresh_token_is_revoked) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The refresh token has been revoked.'
                ]);
            }

            $payload = JwtController::decode_jwt($refresh_token);
            $refresh_token_has_expired = strtotime('now') >= $payload->exp;
            if (
                $payload->type != 'refresh_token'
                || $refresh_token_has_expired
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The refresh token is invalid or has expired.'
                ], 401);
            }

            $expiration_jwt = strtotime('+30 seconds');

            $access_token = JwtController::generate_jwt([
                'name' => $payload->name,
                'email' => $payload->email,
                'exp' => $expiration_jwt,
                'type' => 'access_token'
            ]);

            return response()->json([
                'status' => 'success',
                'access_token' => $access_token
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred'
            ]);
        }

    }
}
