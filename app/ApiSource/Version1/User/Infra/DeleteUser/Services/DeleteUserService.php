<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Infra\DeleteUser\Services;

use App\Models\User;

class DeleteUserService
{
    public function delete(int $userId): void
    {
        User::destroy($userId);
    }
}
