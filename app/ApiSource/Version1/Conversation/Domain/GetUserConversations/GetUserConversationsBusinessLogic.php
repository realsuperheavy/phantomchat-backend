<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Domain\GetUserConversations;

use App\ApiSource\Version1\Conversation\Infra\GetUserConversations\Services\GetConversationsFromDatabaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetUserConversationsBusinessLogic
{
    private GetConversationsFromDatabaseService $getConversationsFromDatabaseService;

    public function __construct(
        GetConversationsFromDatabaseService $getConversationsFromDatabaseService
    ) {
        $this->getConversationsFromDatabaseService = $getConversationsFromDatabaseService;
    }

    public function getConversations(int $userId): LengthAwarePaginator
    {
        return $this->getConversationsFromDatabaseService->getConversations($userId);
    }
}
