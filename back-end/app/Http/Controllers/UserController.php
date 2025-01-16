<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;

use App\Http\Controllers\JwtController;

class UserController extends Controller
{
    public function sign_up(Request $request) {
        try {
            User::create([
                'name' => $request->get('name'),
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

            $expiration = strtotime('+15 minutes');

            $jwt = JwtController::generate_jwt([
                'name' => $user->name,
                'email' => $user->email,
                'exp' => $expiration
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'The authentication has succeded',
                'jwt' => $jwt
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }
}
