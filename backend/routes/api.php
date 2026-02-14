<?php

use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        '/account/yandex',
        [AccountController::class, 'saveYandex']
    );
    Route::get('/account', [AccountController::class, 'show']);
});
