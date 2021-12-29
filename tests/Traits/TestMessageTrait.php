<?php


namespace Tests\Traits;


use App\Models\Message;
use Illuminate\Support\Carbon;

trait TestMessageTrait
{
    private function createMessage(
        string $id,
        ?string $body,
        string $type,
        ?string $filePath,
        int $conversationId,
        int $senderId,
        Carbon $createdAt,
        Carbon $sentAtLocalTime
    ): Message {
        $message = new Message();
        $message
            ->setId($id)
            ->setBody($body)
            ->setType($type)
            ->setFilePath($filePath)
            ->setConversationId($conversationId)
            ->setSenderId($senderId)
            ->setCreatedAt($createdAt)
            ->setSentAtLocalTime($sentAtLocalTime);

        return $message;
    }
}
