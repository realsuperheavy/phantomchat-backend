<?php

//PUBLIC
require __DIR__ . '/auth.php';
require __DIR__ . '/app_log.php';

//PRIVATE
Route::middleware('auth:sanctum')->group(
    function () {
        require __DIR__ . '/push_token.php';
        require __DIR__ . '/message.php';
        require __DIR__ . '/user.php';
        require __DIR__ . '/conversation.php';
    }
);

