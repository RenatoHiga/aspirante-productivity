<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JwtController extends Controller
{
    private static function baseurl64_encode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private static function baseurl64_decode($string) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
    }

    public static function generate_jwt(array $payload): string {
        $header = json_encode([
            "alg" => "HS256",
            "typ" => "JWT",
        ]);

        $payload = json_encode($payload);

        $header_payload = static::baseurl64_encode($header) . '.' . static::baseurl64_encode($payload);
        $signature = hash_hmac('sha256', $header_payload, env('JWT_SECRET_KEY', 'my-secret-key'), true);

        return static::baseurl64_encode($header) . '.' . static::baseurl64_encode($payload) . '.' . static::baseurl64_encode($signature);
    }

    public static function decode_jwt(string $token) {
        $token = explode('.', $token);
        $payload = static::baseurl64_decode($token[1]);
        $signature = static::baseurl64_decode($token[2]);

        $header_payload = $token[0] . '.' . $token[1];

        if (hash_hmac('sha256', $header_payload, env('JWT_SECRET_KEY', default: 'my-secret-key'), true) !== $signature) {
            throw new \Exception('Invalid signature');
        }

        return json_decode($payload);
    }
}
