<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\GetConversation\Specification;

use App\Models\ConversationUser;
use App\Models\User;

class CanUserAccessConversationSpecification
{
    public function isSatisfied(int $conversationId, int $userId): bool
    {
        $sender = User::find($userId);
        if ($sender->isSystemUser()) {
            return true;
        }

        $count = ConversationUser::where('conversation_id', $conversationId)
            ->where('user_id', $userId)
            ->count();

        if (0 === $count) {
            return false;
        }

        return true;
    }
}
