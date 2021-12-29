<?php

namespace App\ApiSource\Version1\Message\Infra\SendMessage\Factories;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

class CreateMessageFactory
{
    public function create(
        int $senderId,
        int $conversationId,
        string $messageType,
        Carbon $sentAtLocalTime,
        ?string $body,
        ?string $filePath
    ): Message {
        $message = new Message();
        $message
            ->setType($messageType)
            ->setBody($body)
            ->setSenderId($senderId)
            ->setConversationId($conversationId)
            ->setFilePath($filePath)
            ->setSentAtLocalTime($sentAtLocalTime)
            ->setId(Uuid::uuid4()->toString())
            ->setCreatedAt(Carbon::now());

        $conversation = Conversation::find($message->getConversationId());
        $conversation->setUpdatedAt(Carbon::now())->save();

        return $message;
    }
}
