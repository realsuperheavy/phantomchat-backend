<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\GetConversation\Services;

use App\Models\Conversation;

class RestoreTrashedConversationUserService
{
    public function restore(Conversation $conversation, int $currentUserId): void
    {
        $conversation->conversationUsers()
            ->withTrashed()
            ->where('user_id', $currentUserId)
            ->first()
            ->restore();
    }
}
