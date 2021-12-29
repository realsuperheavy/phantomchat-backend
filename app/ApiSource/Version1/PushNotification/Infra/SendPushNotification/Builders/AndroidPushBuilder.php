<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use Kreait\Firebase\Messaging\AndroidConfig;

class AndroidPushBuilder
{
    public function buildConfig(PushNotificationValueInterface $payload): AndroidConfig
    {
        $configArray = [
            'priority' => 'normal',
            'notification' => [
                'title' => $payload->getTitle(),
                'body' => $payload->getBody(),
                'sound' => $payload->getSound(),
            ],
        ];

        return AndroidConfig::fromArray($configArray);
    }
}
