<?php

namespace Tests\Feature\ApiSource\Version1\Message\Application\Controllers;

use App\ApiSource\Version1\Message\Infra\SendMessage\Services\DispatchPushNotificationService;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class MessageControllerTest extends FeatureTestCase
{
    use TestUserTrait;

    /** @var User */
    private $userA;
    /** @var User */
    private $userB;
    /** @var int */
    private $conversationId;
    /** @var Conversation */
    private $conversation;

    protected function setUp(): void
    {
        parent::setUp();
        $knownDate = Carbon::create(2021, 9, 26, 13, 0, 0);
        Carbon::setTestNow($knownDate);
    }

    protected function tearDown(): void
    {
        $this->userA = null;
        $this->userB = null;
        $this->conversationId = null;
        $this->conversation = null;
        parent::tearDown();
    }

    public function testSendMessageToConversationYouAreNotPartOf()
    {
        $userB = User::factory()->create();

        $response = $this
            ->actingAs($userB)
            ->postJson(
                'api/v1/message',
                [
                    'conversation_id' => 1,
                    'body' => 'test',
                    'message_hash' => 'aaa',
                    'sent_at_local_time' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );

        $response->assertForbidden();
        $decoded = $response->decodeResponseJson();
        $this->assertEquals("You are not part of this conversation.", $decoded['message']);
    }

    public function testUserASendsGifMessage(): void
    {
        $this->createConversation();
        $this->mockDispatchPushNotificationService($this->userA->getId());

        $response = $this->sendMessage(
            $this->userA,
            'https://media.giphy.com/media/stqfN7Rp5pl8DW9Lc2/giphy.gif',
            null,
            null
        );
        $decodedResponse = $response->decodeResponseJson();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => $decodedResponse['data']['id'],
                    'body' => null,
                    'body_formatted' => $this->userA->getUsername() . ' sent a gif',
                    'sender' => [
                        'id' => $this->userA->getId(),
                        'username' => $this->userA->getUsername(),
                        'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                    ],
                    'type' => 'gif',
                    'file_url' => 'https://media.giphy.com/media/stqfN7Rp5pl8DW9Lc2/giphy.gif',
                    'created_at' => '2021-09-26 13:00:00',
                    'sent_at_local_time' => '2021-09-26 13:00:00',
                    'message_hash' => 'abc123',
                ],
            ],
        );
    }

    public function testUserASendsTextMessage(): void
    {
        $this->createConversation();
        $this->mockDispatchPushNotificationService($this->userA->getId());

        $response = $this->sendMessage(
            $this->userA,
            null,
            'this is so cool body',
            null,
        );
        $decodedResponse = $response->decodeResponseJson();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => $decodedResponse['data']['id'],
                    'body' => 'this is so cool body',
                    'body_formatted' => 'this is so cool body',
                    'sender' => [
                        'id' => $this->userA->getId(),
                        'username' => $this->userA->getUsername(),
                        'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                    ],
                    'type' => 'text',
                    'file_url' => null,
                    'created_at' => '2021-09-26 13:00:00',
                    'sent_at_local_time' => '2021-09-26 13:00:00',
                    'message_hash' => 'abc123',
                ],
            ],
        );
    }

    public function testUserASendsImageMessage(): void
    {
        $knownDate = Carbon::create(2021, 12, 29);
        Carbon::setTestNow($knownDate);

        Storage::fake('public', ['url' => 'http://phantomchat.loc/storage/']);
        $file = UploadedFile::fake()->image('image.jpg', 500, 500);

        $this->createConversation();
        $this->mockDispatchPushNotificationService($this->userA->getId());

        $response = $this->sendMessage(
            $this->userA,
            null,
            'this is so cool body',
            $file
        );
        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals(
            'http://phantomchat.loc/storage/post-media/2021-12-29/' . $file->hashName(),
            $decodedResponse['data']['file_url']
        );
        $this->assertEquals(
            'this is so cool body',
            $decodedResponse['data']['body']
        );
    }

    private function createConversation(): void
    {
        $this->userA = $this->newUser();
        $this->userB = $this->getTestUser();

        $response = $this
            ->actingAs($this->userA)
            ->postJson(
                'api/v1/conversation',
                [
                    'user_ids' => [$this->userB->getId()]
                ]
            );

        $decoded = $response->decodeResponseJson();
        $this->conversationId = $decoded['data']['id'];
        $this->conversation = Conversation::find($this->conversationId);
    }

    private function mockDispatchPushNotificationService(int $senderId, int $times = 1): void
    {
        $this->mock(
            DispatchPushNotificationService::class,
            function (MockInterface $mock) use ($senderId, $times) {
                $mock->shouldReceive('dispatchPushNotificationJob')
                    ->with(\Mockery::type(Message::class))
                    ->times($times);
            }
        );
    }

    private function sendMessage(
        User $user,
        ?string $fileUrl,
        ?string $body,
        ?UploadedFile $file
    ) {
        return $this
            ->actingAs($user)
            ->postJson(
                'api/v1/message',
                [
                    'conversation_id' => $this->conversationId,
                    'file_url' => $fileUrl,
                    'file' => $file,
                    'message_hash' => 'abc123',
                    'body' => $body,
                    'sent_at_local_time' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );
    }

}
