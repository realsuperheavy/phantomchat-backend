<?php

use App\ApiSource\Version1\Conversation\Application\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;


Route::prefix('conversation')->group(function() {
    Route::post('', [ConversationController::class, 'create']);
    Route::get('', [ConversationController::class, 'get']);
    Route::get('/{id}', [ConversationController::class, 'getOne']);
    Route::delete('/{id}', [ConversationController::class, 'delete']);
});
