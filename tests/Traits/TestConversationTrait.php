<?php

namespace Tests\Traits;

use App\Models\Conversation;
use App\Models\ConversationUser;

trait TestConversationTrait
{
    private function getConversationBetweenTwoUsers(int $userOne, int $userTwo): Conversation
    {
        $conversationUsers = ConversationUser::where('user_id', $userOne)->get()->pluck('conversation_id')->toArray();

        return ConversationUser::where('user_id', $userTwo)
            ->whereIn('conversation_id', $conversationUsers)
            ->first()
            ->conversation;
    }

    private function getFirstConversationByUser(int $userId): Conversation
    {
        return ConversationUser::where('user_id', $userId)
            ->first()
            ->conversation;
    }
}
