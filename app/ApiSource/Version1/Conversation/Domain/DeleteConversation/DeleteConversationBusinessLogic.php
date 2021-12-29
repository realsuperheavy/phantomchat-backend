<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Domain\DeleteConversation;

use App\ApiSource\Version1\Conversation\Infra\DeleteConversation\Services\DeleteConversationService;
use App\ApiSource\Version1\Conversation\Infra\DeleteConversation\Specifications\CanUserDeleteConversationSpecification;
use App\ApiSource\Version1\Conversation\Infra\GetConversation\Specification\CanUserAccessConversationSpecification;
use App\ApiSource\Version1\Exception\GenericException;
use Illuminate\Http\Response;

class DeleteConversationBusinessLogic
{
    private CanUserAccessConversationSpecification $canUserAccessConversationSpecification;
    private DeleteConversationService $deleteConversationService;

    public function __construct(
        CanUserAccessConversationSpecification $canUserAccessConversationSpecification,
        DeleteConversationService $deleteConversationService
    ) {
        $this->canUserAccessConversationSpecification = $canUserAccessConversationSpecification;
        $this->deleteConversationService = $deleteConversationService;
    }

    public function delete(int $conversationId, int $userId): void
    {
        if (!$this->canUserAccessConversationSpecification->isSatisfied($conversationId, $userId)) {
            throw new GenericException(
                __('v1/conversation.delete.cannot_delete_conversation'),
                Response::HTTP_FORBIDDEN
            );
        }

        $this->deleteConversationService->delete($conversationId, $userId);
    }
}
