<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KnifeController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::delete('/logout', 'logout')->middleware('auth:sanctum');
});

Route::prefix('knife')->controller(KnifeController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', 'getList');
        Route::post('/store', 'store');
    });
