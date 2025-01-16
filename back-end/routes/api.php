<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtValidator;

Route::prefix('v1')->group(function () {
    Route::withoutMiddleware([JwtValidator::class])->group(function() {
        Route::post('login', [UserController::class, 'login']);
        Route::post('sign_up', [UserController::class, 'sign_up']);
    });

    Route::post('/test', function() {
        dd("testing middleware");
    });
});

