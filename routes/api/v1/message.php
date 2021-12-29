<?php

use App\ApiSource\Version1\Message\Application\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::prefix('message')->group(
    function () {
        Route::post('', [MessageController::class, 'send']);
    }
);
