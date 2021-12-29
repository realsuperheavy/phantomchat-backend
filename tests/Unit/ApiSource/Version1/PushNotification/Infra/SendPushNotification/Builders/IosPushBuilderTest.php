<?php

namespace Tests\Unit\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders\IosPushBuilder;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use Tests\TestCase;

class IosPushBuilderTest extends TestCase
{
    public function testCreateConfig()
    {
        $pushNotificationGeneral = new PushNotificationGeneral('my title', 'my body');
        $result = $this->getService()->buildConfig($pushNotificationGeneral);
        $expected = [
            "payload" => [
                "aps" => [
                    "alert" => [
                        "title" => "my title",
                        "body" => "my body",
                    ],
                    "sound" => "default",
                    "badge" => 0,
                ],
            ],
        ];

        $this->assertEquals($expected, $result->jsonSerialize());
    }

    private function getService(): IosPushBuilder
    {
        return new IosPushBuilder();
    }
}
