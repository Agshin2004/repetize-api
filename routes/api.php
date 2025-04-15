<?php

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
});
