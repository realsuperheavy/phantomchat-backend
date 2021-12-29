<?php

use App\ApiSource\Version1\User\Application\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->group(
    function () {
        Route::get('me', [UserController::class, 'getMe']);
        Route::get('search', [UserController::class, 'search']);
        Route::get('{username}', [UserController::class, 'getByUsername']);
        Route::delete('', [UserController::class, 'delete']);
        Route::patch('', [UserController::class, 'update']);
    }
);
