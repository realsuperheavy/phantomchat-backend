<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use Illuminate\Database\Eloquent\Collection;

interface PushNotificationSenderInterface
{
    public function sendPushNotification(
        PushNotificationValueInterface $payload,
        Collection $tokens
    ): void ;
}
