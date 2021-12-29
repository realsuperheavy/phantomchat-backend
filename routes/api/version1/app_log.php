<?php

use App\ApiSource\Version1\AppLogs\Controllers\AppLogsController;

Route::prefix('app-log')->group(
    function () {
        Route::post('', [AppLogsController::class, 'create']);
    }
);


