<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\JwtController;
use App\Http\Controllers\UserController;

Route::post('v1/login', [UserController::class, 'login']);

Route::post('v1/sign_up', [UserController::class, 'sign_up']);
