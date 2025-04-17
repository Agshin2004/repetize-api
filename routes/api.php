<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\DeskController;
use App\Http\Controllers\Api\V1\AuthController;

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('desk', DeskController::class);
    Route::apiResource('card', CardController::class);

    // Auth routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register'])->middleware('isAuthenticated');
        Route::post('/login', [AuthController::class, 'login'])->middleware('isAuthenticated');
        Route::get('/checkToken', [AuthController::class, 'someMethod']);

        // * auth:api - middleware to ensure only authenticatd users (with valid jwt) can access those routes
        // * auth - middleware; api - argument passed to it
        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::get('/refresh', [AuthController::class, 'refresh']);
        });
    });
});
