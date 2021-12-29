<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Message\Domain\SendMessage;

use App\ApiSource\Version1\Conversation\Infra\GetConversation\Specification\CanUserAccessConversationSpecification;
use App\ApiSource\Version1\Exception\GenericException;
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

class SendMessageBusinessLogic
{
    private UploadMediaService $uploadMediaService;
    private CreateMessageFactory $createMessageFactory;
    private DispatchPushNotificationService $dispatchPushNotificationService;
    private GetMessageTypeService $getMessageTypeService;
    private CanUserAccessConversationSpecification $canUserAccessConversationSpecification;

    public function __construct(
        UploadMediaService $uploadMediaService,
        CreateMessageFactory $createMessageFactory,
        DispatchPushNotificationService $dispatchPushNotificationService,
        CanUserAccessConversationSpecification $canUserAccessConversationSpecification,
        GetMessageTypeService $getMessageTypeService
    ) {
        $this->uploadMediaService = $uploadMediaService;
        $this->createMessageFactory = $createMessageFactory;
        $this->dispatchPushNotificationService = $dispatchPushNotificationService;
        $this->canUserAccessConversationSpecification = $canUserAccessConversationSpecification;
        $this->getMessageTypeService = $getMessageTypeService;
    }

    public function send(
        int $senderId,
        int $conversationId,
        Carbon $sentAtLocalTime,
        ?string $body = null,
        ?string $fileUrl = null,
        ?UploadedFile $file = null
    ): Message {
        if (!$this->canUserAccessConversationSpecification->isSatisfied($conversationId, $senderId)) {
            throw new GenericException(
                __('v1/message.send.cannot_send_message_to_this_convo'),
                Response::HTTP_FORBIDDEN
            );
        }

        $messageType = $this->getMessageTypeService->getMessageType($file, $fileUrl);
        $filePath = $this->uploadMediaService->upload($messageType, $file, $fileUrl);

        $lastMessage = $this->createMessageFactory->create(
            $senderId,
            $conversationId,
            $messageType,
            $sentAtLocalTime,
            $body,
            $filePath,
        );


        ResizeImageJob::dispatch($filePath);
        SystemCommunicationEvent::dispatch(new SocketChatMessageSystemCommunicationValue($lastMessage));
        $this->dispatchPushNotificationService->dispatchPushNotificationJob($lastMessage);

        return $lastMessage;
    }
}
