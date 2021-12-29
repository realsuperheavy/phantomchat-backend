<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Domain\CreateConversation;

use App\ApiSource\Version1\Conversation\Domain\GetConversation\GetConversationBusinessLogic;
use App\ApiSource\Version1\Conversation\Infra\CreateConversation\Services\CreateNewConversationService;
use App\ApiSource\Version1\Conversation\Infra\CreateConversation\Specifications\CanUserStartConversationSpecification;
use App\ApiSource\Version1\Conversation\Infra\GetConversation\Services\RestoreTrashedConversationUserService;
use App\ApiSource\Version1\Exception\GenericException;
use App\Models\Conversation;
use Illuminate\Http\Response;

class CreateConversationBusinessLogic
{
    private CreateNewConversationService $createNewConversationService;
    private GetConversationBusinessLogic $getConversationBusinessLogic;
    private CanUserStartConversationSpecification $canUserStartConversationSpecification;
    private RestoreTrashedConversationUserService $restoreTrashedConversationUserService;

    public function __construct(
        CreateNewConversationService $createNewConversationService,
        GetConversationBusinessLogic $getConversationBusinessLogic,
        CanUserStartConversationSpecification $canUserStartConversationSpecification,
        RestoreTrashedConversationUserService $restoreTrashedConversationUserService
    ) {
        $this->createNewConversationService = $createNewConversationService;
        $this->getConversationBusinessLogic = $getConversationBusinessLogic;
        $this->canUserStartConversationSpecification = $canUserStartConversationSpecification;
        $this->restoreTrashedConversationUserService = $restoreTrashedConversationUserService;
    }

    public function create(
        int $currentUserId,
        array $sendToUserIds
    ): Conversation {
        if (!$this->canUserStartConversationSpecification->isSatisfied($currentUserId, $sendToUserIds)) {
            throw new GenericException(
                __('v1/conversation.create.cannot_start_conversation_with_yourself'),
                Response::HTTP_FORBIDDEN
            );
        }

        //Search for trashed models just in case user deleted conversation and wants to "recreate" it
        $conversation = $this->getConversationBusinessLogic->getByUsernames(
            $currentUserId,
            $sendToUserIds,
            true
        );
        if (null !== $conversation) {
            $this->restoreTrashedConversationUserService->restore($conversation, $currentUserId);
            return $conversation;
        }

        return $this->createNewConversationService->create($currentUserId, $sendToUserIds);
    }
}
