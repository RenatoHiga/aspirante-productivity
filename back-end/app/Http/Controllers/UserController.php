<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;

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

        try {
            $user = User::where('email', '=', $request->get('email'))
                ->get()
            ->first();

            dd(Hash::check($request->get('password'), $user->password));

        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ]);
        }
    }
}
