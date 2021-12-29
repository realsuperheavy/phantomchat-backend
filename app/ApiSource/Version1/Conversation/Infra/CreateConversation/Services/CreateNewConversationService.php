<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\CreateConversation\Services;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CreateNewConversationService
{
    public function create(int $currentUserId, array $sendToUserIds): Conversation
    {
        do {
            try {
                $conversation = new Conversation();
                $conversation
                    ->setConversationIdentifier(Uuid::uuid4()->toString())
                    ->save();
                $tryAgain = false;
            } catch (QueryException $e) {
                //unique conversation_identifier
                $tryAgain = true;
            }
        } while (true === $tryAgain);


        $sendToUserIds[] = $currentUserId;
        /** @var int $userId */
        foreach ($sendToUserIds as $userId) {
            $conversationUser = new ConversationUser();
            $conversationUser
                ->setUserId($userId)
                ->setConversationId($conversation->getId())
                ->save()
            ;
        }

        return $conversation->fresh();
    }
}
