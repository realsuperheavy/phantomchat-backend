<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders\PushMessageBuilder;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging;

class FirebasePushNotificationSenderService implements PushNotificationSenderInterface
{
    private Messaging $messaging;
    private PushMessageBuilder $pushNotificationMessageBuilder;

    public function __construct(
        Messaging $messaging,
        PushMessageBuilder $pushNotificationMessageBuilder
    ) {
        $this->messaging = $messaging;
        $this->pushNotificationMessageBuilder = $pushNotificationMessageBuilder;
    }

    public function sendPushNotification(
        PushNotificationValueInterface $payload,
        Collection $tokens
    ): void {
        foreach ($tokens as $token) {
            try {
                $message = $this->pushNotificationMessageBuilder->buildMessage(
                    $payload,
                    $token,
                );

                $this->messaging->validate($message);
                $this->messaging->send($message);
            } catch (Exception $e) {
                Log::channel('push_notifications')->error($e);
            }
        }
    }
}
