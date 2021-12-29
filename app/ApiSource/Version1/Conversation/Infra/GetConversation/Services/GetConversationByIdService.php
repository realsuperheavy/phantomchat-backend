<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Infra\GetConversation\Services;

use App\Models\Conversation;

class GetConversationByIdService
{
    public function getById(int $id): Conversation
    {
        return Conversation::findOrFail($id);
    }
}
