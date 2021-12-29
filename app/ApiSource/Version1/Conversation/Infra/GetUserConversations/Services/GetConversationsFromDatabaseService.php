<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\GetUserConversations\Services;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Services\PaginationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetConversationsFromDatabaseService
{
    public function getConversations(int $userId): LengthAwarePaginator
    {
        $userConversationIds = ConversationUser::select('conversation_id')
            ->where('user_id', $userId)
            ->get()
            ->pluck('conversation_id')
            ->toArray();

        return Conversation::whereIn('id', $userConversationIds)
            ->with(['displayUsers'])
            ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'ASC')
            ->paginate(PaginationService::perPage());
    }
}
