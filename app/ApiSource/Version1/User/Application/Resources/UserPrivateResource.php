<?php

namespace App\ApiSource\Version1\User\Application\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPrivateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var User $user */
        $user = $this;
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'profile_photo' => $user->getProfilePhotoUrl(),
        ];
    }
}
