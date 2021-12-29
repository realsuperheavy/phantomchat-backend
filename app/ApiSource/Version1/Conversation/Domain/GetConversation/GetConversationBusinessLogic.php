<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Domain\GetConversation;

use App\ApiSource\Version1\Conversation\Infra\GetConversation\Services\GetConversationByIdService;
use App\ApiSource\Version1\Conversation\Infra\GetConversation\Services\GetConversationByUsernameService;
use App\ApiSource\Version1\Conversation\Infra\GetConversation\Specification\CanUserAccessConversationSpecification;
use App\ApiSource\Version1\Exception\GenericException;
use App\Models\Conversation;
use Illuminate\Http\Response;

class GetConversationBusinessLogic
{
    private GetConversationByUsernameService $getConversationByUsernameService;
    private CanUserAccessConversationSpecification $canUserAccessConversationSpecification;
    private GetConversationByIdService $getConversationByIdService;

    public function __construct(
        GetConversationByUsernameService $getConversationByUsernameService,
        CanUserAccessConversationSpecification $canUserAccessConversationSpecification,
        GetConversationByIdService $getConversationByIdService
    ) {
        $this->getConversationByUsernameService = $getConversationByUsernameService;
        $this->canUserAccessConversationSpecification = $canUserAccessConversationSpecification;
        $this->getConversationByIdService = $getConversationByIdService;
    }

    public function getByUsernames(
        int $currentUserId,
        array $sendToUserIds,
        bool $withTrashed = false
    ): ?Conversation {
        return $this->getConversationByUsernameService->getByUsernames(
            $currentUserId,
            $sendToUserIds,
            $withTrashed
        );
    }

    public function getByConversationId(int $conversationId, int $userId): Conversation
    {
        if (!$this->canUserAccessConversationSpecification->isSatisfied($conversationId, $userId)) {
            throw new GenericException(
                __('v1/conversation.get_one.you_have_no_access'),
                Response::HTTP_FORBIDDEN
            );
        }

        return $this->getConversationByIdService->getById($conversationId);
    }
}
