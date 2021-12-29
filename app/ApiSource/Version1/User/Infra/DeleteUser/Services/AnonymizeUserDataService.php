<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Infra\DeleteUser\Services;

use App\Models\User;

class AnonymizeUserDataService
{
    public function anonymize(int $userId): void
    {
        $user = User::find($userId);
        $this->anonymizeBasicData($user);
    }

    private function anonymizeBasicData(User $user): void
    {
        $user
            ->setUsername('deleted_user_' . $user->getId())
            ->setEmail('email@email.com_' . $user->getId())
            ->save();
    }
}
