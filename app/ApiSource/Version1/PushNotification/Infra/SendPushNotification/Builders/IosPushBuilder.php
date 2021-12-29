<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use Kreait\Firebase\Messaging\ApnsConfig;

class IosPushBuilder
{
    public function buildConfig(PushNotificationValueInterface $payload): ApnsConfig
    {
        $configArray = [
            'payload' => [
                'aps' => [
                    'alert' => [
                        'title' => $payload->getTitle(),
                        'body' => $payload->getBody(),
                    ],
                    'sound' => $payload->getSound(),
                    'badge' => $payload->getBadge(),
                ],
            ],
        ];

        if ('' !== $payload->getIOSCategory()) {
            $configArray['payload']['aps']['category'] = $payload->getIOSCategory();
        }

        return ApnsConfig::fromArray($configArray);
    }
}
