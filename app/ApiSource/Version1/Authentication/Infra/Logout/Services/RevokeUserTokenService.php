<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\Logout\Services;

use App\Models\User;

class RevokeUserTokenService
{
    public function revoke(int $tokenId, int $userId): void
    {
        $user = User::find($userId);
        $user->tokens()->where('id', $tokenId)->delete();
    }
}
