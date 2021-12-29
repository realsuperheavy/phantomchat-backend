<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\GetConversation\Services;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class GetConversationByUsernameService
{
    public function getByUsernames(
        int $currentUserId,
        array $sendToUserIds,
        bool $withTrashed = false
    ): ?Conversation {
        $userIds = array_merge([$currentUserId], $sendToUserIds);
        $countUserIds = count($userIds);

        $conversationIds = $this->getConversationsBetweenUsers(
            $userIds,
            $countUserIds,
            $withTrashed
        );
        if (empty($conversationIds)) {
            return null;
        }

        $conversationBetweenUsers = $this->getMatchedConversationBetweenUsers(
            $conversationIds,
            $countUserIds,
            $withTrashed
        );

        if (null === $conversationBetweenUsers) {
            return null;
        }

        return Conversation::find($conversationBetweenUsers->getConversationId());
    }

    private function getConversationsBetweenUsers(
        array $userIds,
        int $countUserIds,
        bool $withTrashed
    ): array {
        $conversationUser = $this->getConversationUserQuery($withTrashed);
        /*
          * You might have conversation_id = 1, with users (1,3)
          * and conversation_id = 12, with users (1,3,4,5)
          * SELECT conversation_id
             FROM conversations_users
             WHERE user_id IN (1,3)
             GROUP BY conversation_id
             HAVING COUNT(user_id) = 2
          * In that case you will get 2 results with conversation_id = 1 and 12
          * But if you make WHERE user_id IN (1,3,4,5) AND HAVING COUNT(user_id) = 4, you'll get one result conversation_id = 12
         */
        return $conversationUser
            ->select('conversation_id')
            ->whereIn('user_id', $userIds)
            ->groupBy('conversation_id')
            ->havingRaw(sprintf('COUNT("user_id") = %s', $countUserIds))
            ->get()
            ->pluck('conversation_id')
            ->toArray();
    }

    /**
     * Filter out conversations so you get one matching conversation
     */
    private function getMatchedConversationBetweenUsers(
        array $conversationIds,
        int $countUserIds,
        bool $withTrashed
    ): ?ConversationUser {
        $conversationUser = $this->getConversationUserQuery($withTrashed);
        /**
         * SELECT conversation_id, count(conversation_id) as count
        FROM conversations_users
        WHERE conversation_id IN (1,12)
        GROUP BY conversation_id
        HAVING count = 2;
         */
        return $conversationUser
            ->selectRaw('conversation_id, COUNT(conversation_id) as count')
            ->whereIn('conversation_id', $conversationIds)
            ->groupBy('conversation_id')
            ->havingRaw(sprintf('count = %s', $countUserIds))
            ->first();
    }

    /**
     * @param bool $withTrashed
     * @return ConversationUser|Builder|QueryBuilder
     */
    private function getConversationUserQuery(bool $withTrashed)
    {
        if ($withTrashed) {
            return ConversationUser::withTrashed();
        }

        return ConversationUser::query();
    }
}
