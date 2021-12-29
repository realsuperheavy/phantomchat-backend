<?php

use App\ApiSource\Version1\PushToken\Application\Controllers\PushTokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('push-token')->group(
    function () {
        Route::post('', [PushTokenController::class, 'create']);
    }
);
