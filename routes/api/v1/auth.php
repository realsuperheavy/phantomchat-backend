<?php

use App\ApiSource\Version1\Authentication\Application\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(
    function () {
        Route::post('registration', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('request-login-code', [AuthController::class, 'requestLoginCode']);
        Route::post('social-login', [AuthController::class, 'socialLogin']);

        Route::middleware('auth:sanctum')->group(
            function () {
                Route::post('logout', [AuthController::class, 'logout']);
            }
        );
    }
);
