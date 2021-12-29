<?php

namespace Tests\Unit\ApiSource\Version1\SystemCommunication\Socket\Infra\Services;

use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Events\SocketChatMessageEvent;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Services\SendSocketSystemCommunicationService;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketChatMessageSystemCommunicationValue;
use App\Models\Message;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SendSocketSystemCommunicationServiceTest extends TestCase
{
    public function testSend()
    {
        Event::fake();
        $message = new Message();
        $value = new SocketChatMessageSystemCommunicationValue($message);
        $this->getService()->send($value);
        Event::assertDispatched(
            function (SocketChatMessageEvent $event) use ($value) {
                return $event->socketChatMessageNotificationValue->getMessage() === $value->getMessage();
            }
        );
    }

    private function getService(): SendSocketSystemCommunicationService
    {
        return new SendSocketSystemCommunicationService();
    }
}
