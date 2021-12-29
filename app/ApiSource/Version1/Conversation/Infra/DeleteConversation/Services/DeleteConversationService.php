<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\DeleteConversation\Services;

use App\Models\ConversationUser;

class DeleteConversationService
{
    public function delete(int $conversationId, int $userId): void
    {
        $conversationUser = ConversationUser::where('user_id', $userId)
            ->where('conversation_id', $conversationId)
            ->first();

        if (null === $conversationUser) {
            return;
        }

        $conversationUser->delete();
    }
}
