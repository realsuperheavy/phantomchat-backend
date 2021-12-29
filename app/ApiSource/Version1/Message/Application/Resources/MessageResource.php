<?php

namespace App\ApiSource\Version1\Message\Application\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Message $message */
        $message = $this;

        return [
            'id' => $message->getId(),
            'body' => $message->getBody(),
            'body_formatted' => $message->getBodyFormatted(),
            'sender' => new MessageUserResource($message->getSender()),
            'type' => $message->getType(),
            'file_url' => $message->getFileUrl(),
            'created_at' => $message->getCreatedAt()->format('Y-m-d H:i:s'),
            'sent_at_local_time' => $message->getSentAtLocalTime()->format('Y-m-d H:i:s'),
            'message_hash' => $request->message_hash,
            //this is used to identify returned message with message in the app
        ];
    }
}
