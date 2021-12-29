<?php

namespace App\ApiSource\Version1\Conversation\Application\Resources;

use App\Models\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Conversation $conversation */
        $conversation = $this;

        return [
            'id' => $conversation->getId(),
            'updated_at' => $conversation->getUpdatedAt()->format('Y-m-d H:i:s'),
            'conversation_identifier' => $conversation->getConversationIdentifier(),
            'display_users' => ConversationDisplayUserResource::collection($conversation->displayUsers),
        ];
    }
}
