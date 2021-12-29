<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use App\Models\PushToken;
use Exception;
use Kreait\Firebase\Messaging\CloudMessage;

class PushMessageBuilder
{
    private AndroidPushBuilder $androidPushBuilder;
    private IosPushBuilder $iosPushBuilder;

    public function __construct(
        AndroidPushBuilder $androidPushBuilder,
        IosPushBuilder $iosPushBuilder
    ) {
        $this->androidPushBuilder = $androidPushBuilder;
        $this->iosPushBuilder = $iosPushBuilder;
    }

    public function buildMessage(
        PushNotificationValueInterface $payload,
        PushToken $pushToken
    ): CloudMessage {
        $message = CloudMessage::withTarget('token', $pushToken->getToken());

        $message = $message
            ->withNotification(
                [
                    'title' => $payload->getTitle(),
                    'body' => $payload->getBody(),
                ]
            );

        $message = $this->buildMessageByPlatform($message, $payload, $pushToken);
        $additionalData = array_merge(
            $payload->getAdditionalData(),
            [
                'open_screen' => $payload->getOpenScreen()
            ]
        );
        $message = $message->withData($additionalData);

        return $message;
    }

    private function buildMessageByPlatform(
        CloudMessage $message,
        PushNotificationValueInterface $payload,
        PushToken $pushToken
    ): CloudMessage {
        if (PushToken::PLATFORM_ANDROID === $pushToken->getPlatform()) {
            return $message->withAndroidConfig($this->androidPushBuilder->buildConfig($payload));
        }

        if (PushToken::PLATFORM_IOS === $pushToken->getPlatform()) {
            return $message->withApnsConfig($this->iosPushBuilder->buildConfig($payload));
        }

        throw new Exception(
            sprintf('[FIREBASE] "%s" is unsupported mobile platform', $pushToken->getPlatform())
        );
    }
}
