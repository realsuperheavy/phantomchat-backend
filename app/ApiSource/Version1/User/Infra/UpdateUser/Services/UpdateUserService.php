<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Infra\UpdateUser\Services;

use App\Models\User;

class UpdateUserService
{
    public function update(
        int $userId,
        ?string $username,
        ?string $profilePhotoPath
    ): User {
        $user = User::find($userId);
        if (null !== $username) {
            $user
                ->setUsername($username)
                ->setProfilePhotoPath($profilePhotoPath);
        }

        $user->save();

        return $user->fresh();
    }
}
