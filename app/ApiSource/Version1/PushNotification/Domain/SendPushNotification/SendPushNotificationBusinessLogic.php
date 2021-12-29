<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Domain\SendPushNotification;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\FirebasePushNotificationSenderService;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\GetPushTokensService;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\PushNotificationSenderInterface;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationMessage;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use App\Models\PushToken;

class SendPushNotificationBusinessLogic
{
    private PushNotificationSenderInterface $pushNotificationSender;
    private GetPushTokensService $getPushTokensService;

    public function __construct(
        PushNotificationSenderInterface $pushNotificationSender,
        GetPushTokensService $getPushTokensService
    ) {
        $this->pushNotificationSender = $pushNotificationSender;
        $this->getPushTokensService = $getPushTokensService;
    }

    public function sendPushNotification(
        PushNotificationValueInterface $payload
    ): void {
        $tokenType = '';
        if ($this->pushNotificationSender instanceof FirebasePushNotificationSenderService) {
            $tokenType = PushToken::TOKEN_TYPE_FIREBASE;
        }

        $tokens = [];
        if ($payload instanceof PushNotificationMessage) {
            $tokens = $this->getPushTokensService->getPushTokensFromConversation(
                $payload->getConversationId(),
                $payload->getSenderId(),
                $tokenType
            );
        } elseif ($payload instanceof PushNotificationGeneral) {
            $tokens = $this->getPushTokensService->getPushTokensByUser(
                $payload->getReceiverId(),
                $tokenType
            );
        }

        $this->pushNotificationSender->sendPushNotification($payload, $tokens);
    }
}
