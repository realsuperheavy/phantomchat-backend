<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Conversation\Application\Controllers;

use App\ApiSource\Version1\Conversation\Domain\CreateConversation\CreateConversationBusinessLogic;
use App\ApiSource\Version1\Conversation\Domain\DeleteConversation\DeleteConversationBusinessLogic;
use App\ApiSource\Version1\Conversation\Domain\GetConversation\GetConversationBusinessLogic;
use App\ApiSource\Version1\Conversation\Domain\GetUserConversations\GetUserConversationsBusinessLogic;
use App\ApiSource\Version1\Conversation\Application\Requests\CreateConversationRequest;
use App\ApiSource\Version1\Conversation\Application\Requests\DeleteConversationRequest;
use App\ApiSource\Version1\Conversation\Application\Requests\GetConversationRequest;
use App\ApiSource\Version1\Conversation\Application\Resources\ConversationResource;
use App\ApiSource\Version1\Exception\GenericException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function create(
        CreateConversationRequest $request,
        CreateConversationBusinessLogic $createConversationBusinessLogic
    ): JsonResource {
        try {
            $conversations = $createConversationBusinessLogic->create(
                Auth::id(),
                $request->user_ids
            );

            return new ConversationResource($conversations);
        } catch (GenericException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function get(
        Request $request,
        GetUserConversationsBusinessLogic $getUserConversationsBusinessLogic
    ): JsonResource {
        try {
            $conversations = $getUserConversationsBusinessLogic->getConversations(Auth::id());

            return ConversationResource::collection($conversations);
        } catch (GenericException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function getOne(
        int $id,
        GetConversationRequest $request,
        GetConversationBusinessLogic $getConversationBusinessLogic
    ): JsonResource {
        try {
            $conversations = $getConversationBusinessLogic->getByConversationId($id, Auth::id());

            return new ConversationResource($conversations);
        } catch (GenericException|Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    public function delete(
        int $id,
        DeleteConversationRequest $request,
        DeleteConversationBusinessLogic $deleteConversationBusinessLogic
    ): JsonResponse {
        try {
            $deleteConversationBusinessLogic->delete($id, Auth::id());
            return $this->response([], '');
        } catch (GenericException|Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
