<?php

namespace App\ApiSource\Version1\Conversation\Application\Resources;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ConversationDisplayUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var User $user */
        $user = $this;

        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'profile_photo' => $user->getProfilePhotoUrl(),
        ];
    }
}
