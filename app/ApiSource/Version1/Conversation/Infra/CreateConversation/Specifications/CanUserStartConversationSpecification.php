<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\CreateConversation\Specifications;

use App\Models\User;

class CanUserStartConversationSpecification
{
    public function isSatisfied(
        int $currentUserId,
        array $sendToUserIds
    ): bool {

        //if user tries to send email to himself
        if (count($sendToUserIds) === 1) {
            foreach ($sendToUserIds as $userId) {
                if ($currentUserId === $userId) {
                    return false;
                }
            }
        }

        return true;
    }
}
