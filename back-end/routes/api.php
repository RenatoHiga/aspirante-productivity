<?php

use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtValidator;

Route::prefix('v1')->group(function () {
    Route::withoutMiddleware([JwtValidator::class])->group(function() {
        Route::post('login', [UserController::class, 'login']);
        Route::post('sign_up', [UserController::class, 'sign_up']);
        Route::post('access_token', [UserController::class, 'generate_access_token']);
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/', [TasksController::class, 'get']);
        Route::post('/', [TasksController::class, 'create']);
        Route::patch('/', [TasksController::class, 'update']);
        Route::delete('/', [TasksController::class, 'delete']);
    });

    
});

