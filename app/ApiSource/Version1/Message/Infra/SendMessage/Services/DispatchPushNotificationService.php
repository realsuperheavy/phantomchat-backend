<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Message\Infra\SendMessage\Services;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Jobs\SendPushNotificationJob;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationMessage;
use App\Models\Message;
use App\Models\User;

class DispatchPushNotificationService
{
    public function dispatchPushNotificationJob(Message $lastMessage)
    {
        $sender = User::find($lastMessage->getSenderId());

        $additionalData = [
            'conversation_id' => $lastMessage->getConversationId(),
        ];

        $pushMessage = new PushNotificationMessage(
            $sender->getUsername(),
            $lastMessage->getBodyFormatted(),
            $lastMessage->getConversationId(),
            $sender->getId(),
        );

        $pushMessage
            ->setBadge(1)
            ->setAdditionalData($additionalData)
            ->setOpenScreen(PushNotificationGeneral::SCREEN_MESSAGE);

        SendPushNotificationJob::dispatch($pushMessage);
    }
}
