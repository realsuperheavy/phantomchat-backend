<?php

namespace Tests\Feature\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Factories;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Builders\PushMessageBuilder;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use App\Models\PushToken;
use Illuminate\Support\Facades\App;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\MessageData;
use Kreait\Firebase\Messaging\Notification;
use Tests\FeatureTestCase;

class PushMessageBuilderTest extends FeatureTestCase
{
    public function testForAndroid()
    {
        $pushNotificationGeneral = new PushNotificationGeneral('my title', 'my body');
        $pushToken = new PushToken();
        $pushToken
            ->setToken('abc')
            ->setPlatform(PushToken::PLATFORM_ANDROID);

        $result = $this->getService()->buildMessage(
            $pushNotificationGeneral,
            $pushToken
        );

        $result = $result->jsonSerialize();
        /** @var MessageData $data */
        $data = $result['data'];
        $data = $data->jsonSerialize();
        $this->assertEquals(["open_screen" => "home"], $data);

        /** @var Notification $notification */
        $notification = $result['notification'];
        $notification = $notification->jsonSerialize();
        $this->assertEquals(
            [
                "title" => "my title",
                "body" => "my body",
            ],
            $notification
        );

        /** @var AndroidConfig $android */
        $android = $result['android'];
        $android = $android->jsonSerialize();
        $this->assertEquals(
            [
                "priority" => "normal",
                "notification" => [
                    "title" => "my title",
                    "body" => "my body",
                    "sound" => "default",
                ]
            ],
            $android
        );
    }

    public function testForIos()
    {
        $pushNotificationGeneral = new PushNotificationGeneral('my title', 'my body');
        $pushToken = new PushToken();
        $pushToken
            ->setToken('abc')
            ->setPlatform(PushToken::PLATFORM_IOS);

        $result = $this->getService()->buildMessage(
            $pushNotificationGeneral,
            $pushToken
        );

        $result = $result->jsonSerialize();
        /** @var MessageData $data */
        $data = $result['data'];
        $data = $data->jsonSerialize();
        $this->assertEquals(["open_screen" => "home"], $data);

        /** @var Notification $notification */
        $notification = $result['notification'];
        $notification = $notification->jsonSerialize();
        $this->assertEquals(
            [
                "title" => "my title",
                "body" => "my body",
            ],
            $notification
        );

        /** @var  $ios */
        $ios = $result['apns'];
        $ios = $ios->jsonSerialize();
        $this->assertEquals(
            [
                "payload" => [
                    "aps" => [
                        "alert" => [
                            "title" => "my title",
                            "body" => "my body",
                        ],
                        "sound" => "default",
                        "badge" => 0,
                    ]
                ]
            ],
            $ios
        );
    }

    private function getService(): PushMessageBuilder
    {
        return App::make(PushMessageBuilder::class);
    }
}
