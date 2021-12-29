<?php

namespace Tests\Unit\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders\AndroidPushBuilder;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use Tests\TestCase;

class AndroidPushBuilderTest extends TestCase
{
    public function testCreateConfig()
    {
        $pushNotificationGeneral = new PushNotificationGeneral('my title', 'my body');
        $result = $this->getService()->buildConfig($pushNotificationGeneral);
        $expected = [
            "priority" => "normal",
            "notification" => [
                "title" => "my title",
                "body" => "my body",
                "sound" => "default",
            ]
        ];
        $this->assertEquals($expected, $result->jsonSerialize());
    }

    private function getService(): AndroidPushBuilder
    {
        return new AndroidPushBuilder();
    }
}
