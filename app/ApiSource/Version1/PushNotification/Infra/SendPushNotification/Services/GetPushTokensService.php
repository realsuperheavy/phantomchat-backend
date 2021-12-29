<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services;

use App\Models\ConversationUser;
use App\Models\PushToken;
use Illuminate\Database\Eloquent\Collection;

class GetPushTokensService
{
    public function getPushTokensFromConversation(int $conversationId, int $senderId, string $tokenType): Collection
    {
        $peopleInConversation = ConversationUser::where('user_id', '!=', $senderId)
            ->where('conversation_id', $conversationId)
            ->get()
            ->pluck('user_id')
            ->toArray();

        return PushToken::where('token_type', $tokenType)
            ->whereIn('user_id', $peopleInConversation)
            ->get();
    }

    public function getPushTokensByUser(int $userId, string $tokenType): Collection
    {
        return PushToken::where('token_type', $tokenType)
            ->where('user_id', $userId)
            ->get();
    }
}
