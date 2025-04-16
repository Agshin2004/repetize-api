<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Middleware\V1\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\DeskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('desk', DeskController::class);
    Route::apiResource('card', CardController::class);

    // Auth routes
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/refresh', [AuthController::class, 'refresh']);

        Route::post('/register', [AuthController::class, 'register'])->middleware(RedirectIfAuthenticated::class);
        Route::post('/login', [AuthController::class, 'login'])->middleware(RedirectIfAuthenticated::class);
        ;
    });
});
