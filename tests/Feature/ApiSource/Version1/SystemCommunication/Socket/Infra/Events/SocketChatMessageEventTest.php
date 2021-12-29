<?php

namespace Tests\Feature\ApiSource\Version1\SystemCommunication\Socket\Infra\Events;

use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Events\SocketChatMessageEvent;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketChatMessageSystemCommunicationValue;
use App\Models\Message;
use Illuminate\Support\Carbon;
use Tests\FeatureTestCase;
use Tests\Traits\TestMessageTrait;

class SocketChatMessageEventTest extends FeatureTestCase
{
    use TestMessageTrait;

    public function testBroadcastOn()
    {
        $response = $this->getService()->broadcastOn();
        $this->assertEquals($response->name, 'socket_chat_message_channel');
    }

    public function testBroadcastAs()
    {
        $response = $this->getService()->broadcastAs();
        $this->assertEquals($response, 'SocketChatMessageNotificationEvent');
    }

    public function testBroadcastWith()
    {
        $knownDate = Carbon::create(2021, 10, 04, 13, 0, 0);
        Carbon::setTestNow($knownDate);

        $response = $this->getService()->broadcastWith();
        $expected = [
            'id' => 1,
            'body' => null,
            'body_formatted' => 'test sent a gif',
            'sender' => [
                'id' => 1,
                'username' => 'test',
                'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
            ],
            'type' => 'gif',
            'file_url' => 'https://media.giphy.com/media/bUyNEbEglZg41CMw6y/giphy.gif',
            'created_at' => '2021-10-04 13:00:00',
            'sent_at_local_time' => '2021-10-04 13:00:00',
            'message_hash' => null,
            'conversation_identifier' => 'identifier_uuid_1',
        ];

        $this->assertEquals($expected, $response);
    }

    private function getService(): SocketChatMessageEvent
    {
        $message = $this->createMessage(
            '1',
            null,
            Message::TYPE_GIF,
            'https://media.giphy.com/media/bUyNEbEglZg41CMw6y/giphy.gif',
            1,
            1,
            Carbon::now(),
            Carbon::now(),
        );

        $value = new SocketChatMessageSystemCommunicationValue($message);

        return new SocketChatMessageEvent($value);
    }
}
