<?php

namespace Tests\Unit\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Jobs;

use App\ApiSource\Version1\PushNotification\Domain\SendPushNotification\SendPushNotificationBusinessLogic;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Jobs\SendPushNotificationJob;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use Illuminate\Support\Facades\Config;
use Mockery\MockInterface;
use Tests\TestCase;

class SendPushNotificationJobTest extends TestCase
{
    private $pushNotificationGeneral;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pushNotificationGeneral = new PushNotificationGeneral('title', 'body');
    }

    public function testQueue()
    {
        $this->assertEquals($this->getService()->queue, 'push_notifications_queue');
    }

    public function testHandle()
    {
        Config::set('app.send_push', true);
        $this->getService()->handle(
            $this->mockSendPushNotificationBusinessLogic()
        );
        $this->assertEquals($this->getService()->queue, 'push_notifications_queue');
    }

    private function mockSendPushNotificationBusinessLogic(): MockInterface
    {
        return $this->mock(
            SendPushNotificationBusinessLogic::class,
            function (MockInterface $mock) {
                $mock
                    ->shouldReceive('sendPushNotification')
                    ->with($this->pushNotificationGeneral)
                    ->once();
            }
        );
    }

    private function getService(): SendPushNotificationJob
    {
        return new SendPushNotificationJob($this->pushNotificationGeneral);
    }
}
