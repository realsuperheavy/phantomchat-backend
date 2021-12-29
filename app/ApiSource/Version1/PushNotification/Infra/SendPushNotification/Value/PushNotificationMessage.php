<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value;

class PushNotificationMessage extends PushNotificationGeneral
{
    private int $conversationId;
    private int $senderId;

    public function __construct(
        string $title,
        string $body,
        int $conversationId,
        int $senderId
    ) {
        $this->conversationId = $conversationId;
        $this->senderId = $senderId;

        parent::__construct(
            $title,
            $body,
        );
    }

    public function getConversationId(): int
    {
        return $this->conversationId;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }
}
