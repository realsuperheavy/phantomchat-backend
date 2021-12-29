<?php

namespace Tests\Unit\ApiSource\Version1\PushNotification\Domain\SendPushNotification;

use App\ApiSource\Version1\PushNotification\Domain\SendPushNotification\SendPushNotificationBusinessLogic;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\FirebasePushNotificationSenderService;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\GetPushTokensService;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\PushNotificationSenderInterface;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationMessage;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use App\Models\PushToken;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class SendPushNotificationBusinessLogicTest extends TestCase
{
    private $pushNotificationSender;
    private $getPushTokensService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pushNotificationSender = $this->mock(PushNotificationSenderInterface::class);
        $this->getPushTokensService = $this->mock(GetPushTokensService::class);
    }

    protected function tearDown(): void
    {
        $this->pushNotificationSender = null;
        $this->getPushTokensService = null;
    }

    public function testWithPushNotificationMessage()
    {
        $pushNotificationMessage = new PushNotificationMessage(
            'title',
            'body',
            444,
            222
        );

        $this->mockGetPushTokensServiceFromConversations();
        $this->mockFirebasePushNotificationSender($pushNotificationMessage);
        $this->getService()->sendPushNotification($pushNotificationMessage);
        $this->assertTrue(true); //just so phpunit does not complain about not performing assertions
    }


    public function testWithPushNotificationGeneral()
    {
        $pushNotificationGeneral = new PushNotificationGeneral(
            'title',
            'body',
        );
        $pushNotificationGeneral->setReceiverId(333);

        $this->mockGetPushTokensServiceByUser();
        $this->mockFirebasePushNotificationSender($pushNotificationGeneral);
        $this->getService()->sendPushNotification($pushNotificationGeneral);
        $this->assertTrue(true); //just so phpunit does not complain about not performing assertions
    }

    private function mockFirebasePushNotificationSender(PushNotificationValueInterface $pushNotificationMessage)
    {
        $this->pushNotificationSender =
            $this->mock(
                FirebasePushNotificationSenderService::class,
                function (MockInterface $mock) use ($pushNotificationMessage) {
                    $mock->shouldReceive('sendPushNotification')
                        ->with(
                            $pushNotificationMessage,
                            \Mockery::type(Collection::class)
                        )
                        ->once();
                }
            );
    }

    private function mockGetPushTokensServiceFromConversations()
    {
        $this->getPushTokensService =
            $this->mock(
                GetPushTokensService::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('getPushTokensFromConversation')
                        ->with(
                            444,
                            222,
                            PushToken::TOKEN_TYPE_FIREBASE
                        )
                        ->once()
                        ->andReturn(new Collection());
                }
            );
    }

    private function mockGetPushTokensServiceByUser()
    {
        $this->getPushTokensService =
            $this->mock(
                GetPushTokensService::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('getPushTokensByUser')
                        ->with(333, PushToken::TOKEN_TYPE_FIREBASE)
                        ->once();
                }
            );
    }

    private function getService(): SendPushNotificationBusinessLogic
    {
        return new SendPushNotificationBusinessLogic(
            $this->pushNotificationSender,
            $this->getPushTokensService
        );
    }
}
