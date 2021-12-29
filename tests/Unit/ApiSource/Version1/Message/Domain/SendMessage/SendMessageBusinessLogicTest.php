<?php

namespace Tests\Unit\ApiSource\Version1\Message\Domain\SendMessage;

use App\ApiSource\Version1\Conversation\Infra\GetConversation\Specification\CanUserAccessConversationSpecification;
use App\ApiSource\Version1\Exception\GenericException;
use App\ApiSource\Version1\Message\Domain\SendMessage\SendMessageBusinessLogic;
use App\ApiSource\Version1\Message\Infra\SendMessage\Factories\CreateMessageFactory;
use App\ApiSource\Version1\Message\Infra\SendMessage\Jobs\ResizeImageJob;
use App\ApiSource\Version1\Message\Infra\SendMessage\Services\DispatchPushNotificationService;
use App\ApiSource\Version1\Message\Infra\SendMessage\Services\GetMessageTypeService;
use App\ApiSource\Version1\Message\Infra\SendMessage\Services\UploadMediaService;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketChatMessageSystemCommunicationValue;
use App\Models\Message;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Tests\TestCase;

class SendMessageBusinessLogicTest extends TestCase
{
    private $uploadMediaService;
    private $createMessageFactory;
    private $dispatchPushNotificationService;
    private $canUserAccessConversationSpecification;
    private $getMessageTypeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uploadMediaService = $this->mock(UploadMediaService::class);
        $this->createMessageFactory = $this->mock(CreateMessageFactory::class);
        $this->dispatchPushNotificationService = $this->mock(DispatchPushNotificationService::class);
        $this->canUserAccessConversationSpecification = $this->mock(CanUserAccessConversationSpecification::class);
        $this->getMessageTypeService = $this->mock(GetMessageTypeService::class);
    }

    protected function tearDown(): void
    {
        $this->uploadMediaService = null;
        $this->createMessageFactory = null;
        $this->dispatchPushNotificationService = null;
        $this->getMessageTypeService = null;
        parent::tearDown();
    }

    public function testWhenUserCannotSendMessageToTheConversation()
    {
        $this->mockCanUserAccessConversationSpecification(false);
        $this->expectException(GenericException::class);
        $this->expectExceptionMessage('You are not part of this conversation.');
        $this->expectExceptionCode(Response::HTTP_FORBIDDEN);
        $this->getService()->send(222, 111, Carbon::now(), null, null);
    }

    /**
     * @dataProvider messageCombinations
     */
    public function testMultipleCombinations(
        string $messageType,
        ?string $body,
        ?UploadedFile $uploadedFile,
        ?string $filePath,
        ?string $fileUrl
    ) {
        Bus::fake();
        Event::fake();

        $this->mockUploadMediaService(
            $messageType,
            $uploadedFile,
            $fileUrl,
            $filePath,
        );
        $this->mockCreateMessageFactory(
            222,
            111,
            $messageType,
            $body,
            $filePath,
        );
        $this->mockDispatchPushNotificationService();
        $this->mockCanUserAccessConversationSpecification(true);
        $this->mockGetMessageTypeService($uploadedFile, $fileUrl, $messageType);

        $this->getService()->send(
            222,
            111,
            Carbon::now(),
            $body,
            $fileUrl,
            $uploadedFile
        );

        Bus::assertDispatched(ResizeImageJob::class);

        Event::assertDispatched(
            function (SystemCommunicationEvent $event) use ($filePath, $fileUrl, $body, $messageType) {
                /** @var SocketChatMessageSystemCommunicationValue $eventOne */
                $eventOne = $event->communicationValues[0];
                $message = $eventOne->getMessage();
                return
                    $message->getSenderId() === 222 &&
                    $message->getConversationId() === 111 &&
                    $message->getType() === $messageType &&
                    $message->getFilePath() === ($filePath ?? $fileUrl) &&
                    $message->getBody() === $body;
            }
        );
    }


    public function messageCombinations(): array
    {
        /*
        $messageType,
        $body,
        $uploadedFile,
        $filePath
        $fileUrl
        */
        return [
            'only text message' => [
                Message::TYPE_TEXT,
                'some body',
                null,
                null,
                null,
            ],
            'only upload image' => [
                Message::TYPE_IMAGE,
                null,
                UploadedFile::fake()->create('image.jpg', 10),
                '/path/to/image.jpg',
                null,
            ],
            'only upload video' => [
                Message::TYPE_VIDEO,
                null,
                UploadedFile::fake()->create('video.mp4', 10),
                '/path/to/video.mp4',
                null,
            ],
            'only with file url (gif)' => [
                Message::TYPE_GIF,
                null,
                null,
                'https://www.domain.com/haha.gif',
                'https://www.domain.com/haha.gif'
            ],

            'image + body' => [
                Message::TYPE_IMAGE,
                'some body',
                UploadedFile::fake()->create('video.mp4', 10),
                '/path/to/video.mp4',
                null,
            ],
        ];
    }

    private function mockCanUserAccessConversationSpecification(bool $return)
    {
        $this->canUserAccessConversationSpecification =
            $this->mock(
                CanUserAccessConversationSpecification::class,
                function (MockInterface $mock) use ($return) {
                    $mock->shouldReceive('isSatisfied')
                        ->with(111, 222)
                        ->once()
                        ->andReturn($return);
                }
            );
    }

    private function mockUploadMediaService(
        string $type,
        ?UploadedFile $file,
        ?string $fileUrl,
        ?string $return
    ) {
        $this->uploadMediaService =
            $this->mock(
                UploadMediaService::class,
                function (MockInterface $mock) use ($type, $file, $fileUrl, $return) {
                    $mock->shouldReceive('upload')
                        ->with($type, $file, $fileUrl)
                        ->once()
                        ->andReturn($return);
                }
            );
    }

    private function mockCreateMessageFactory(
        int $senderId,
        int $conversationId,
        string $messageType,
        ?string $body,
        ?string $filePath
    ) {
        $message = new Message();
        $message
            ->setSenderId(222)
            ->setConversationId(111)
            ->setType($messageType)
            ->setBody($body)
            ->setFilePath($filePath);

        $this->createMessageFactory =
            $this->mock(
                CreateMessageFactory::class,
                function (MockInterface $mock) use (
                    $message,
                    $senderId,
                    $conversationId,
                    $messageType,
                    $body,
                    $filePath
                ) {
                    $mock->shouldReceive('create')
                        ->with(
                            $senderId,
                            $conversationId,
                            $messageType,
                            \Mockery::type(Carbon::class),
                            $body,
                            $filePath
                        )
                        ->once()
                        ->andReturn($message);
                }
            );
    }

    private function mockDispatchPushNotificationService()
    {
        $this->dispatchPushNotificationService =
            $this->mock(
                DispatchPushNotificationService::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('dispatchPushNotificationJob')
                        ->with(\Mockery::type(Message::class))
                        ->once();
                }
            );
    }

    private function mockGetMessageTypeService(
        ?UploadedFile $file,
        ?string $fileUrl,
        string $return
    ) {
        $this->getMessageTypeService =
            $this->mock(
                GetMessageTypeService::class,
                function (MockInterface $mock) use ($file, $fileUrl, $return) {
                    $mock->shouldReceive('getMessageType')
                        ->with($file, $fileUrl)
                        ->once()
                        ->andReturn($return);
                }
            );
    }

    private function getService(): SendMessageBusinessLogic
    {
        return new SendMessageBusinessLogic(
            $this->uploadMediaService,
            $this->createMessageFactory,
            $this->dispatchPushNotificationService,
            $this->canUserAccessConversationSpecification,
            $this->getMessageTypeService
        );
    }
}
