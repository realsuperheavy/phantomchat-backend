<?php

namespace Tests\Unit\ApiSource\Version1\SystemCommunication\Base\Infra\Listeners;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Listeners\SystemCommunicationListener;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Services\SendEmailSystemCommunicationService;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Services\SendSocketSystemCommunicationService;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketChatMessageSystemCommunicationValue;
use App\Models\Message;
use Mockery\MockInterface;
use Tests\TestCase;

class SystemCommunicationListenerTest extends TestCase
{
    private $sendEmailNotificationService;
    private $sendSocketNotificationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sendEmailNotificationService = $this->mock(SendEmailSystemCommunicationService::class);
        $this->sendSocketNotificationService = $this->mock(SendSocketSystemCommunicationService::class);
    }

    protected function tearDown(): void
    {
        $this->sendEmailNotificationService = null;
        $this->sendSocketNotificationService = null;
    }

    public function testQueueName()
    {
        $this->assertEquals(
            $this->getService()->queue,
            'system_notifications_queue'
        );
    }

    public function testEmailNotificationValue()
    {
        $event = new EmailSystemCommunicationValue(
            'test@email.com',
            'My subject',
            'views.email.test'
        );
        $notificationEvent = new SystemCommunicationEvent($event);
        $this->mockSendEmailNotificationService();
        $this->getService()->handle($notificationEvent);
        $this->assertTrue(true); //so phpunit is not complaining that there aren't any assertions
    }

    public function testSocketChatMessageNotificationValue()
    {
        $event = new SocketChatMessageSystemCommunicationValue(new Message());
        $notificationEvent = new SystemCommunicationEvent($event);
        $this->mockSendSocketNotificationService(SocketChatMessageSystemCommunicationValue::class);
        $this->getService()->handle($notificationEvent);
        $this->assertTrue(true); //so phpunit is not complaining that there aren't any assertions
    }

    private function mockSendEmailNotificationService()
    {
        $this->sendEmailNotificationService =
            $this->mock(
                SendEmailSystemCommunicationService::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('send')
                        ->with(\Mockery::type(EmailSystemCommunicationValue::class))
                        ->once();
                }
            );
    }

    private function mockSendSocketNotificationService(string $className)
    {
        $this->sendSocketNotificationService =
            $this->mock(
                SendSocketSystemCommunicationService::class,
                function (MockInterface $mock) use ($className) {
                    $mock->shouldReceive('send')
                        ->with(\Mockery::type($className))
                        ->once();
                }
            );
    }

    private function getService(): SystemCommunicationListener
    {
        return new SystemCommunicationListener(
            $this->sendEmailNotificationService,
            $this->sendSocketNotificationService,
        );
    }
}
