<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\User\Infra\DeleteUser\Services;

use App\Models\PushToken;

class RemovePushTokensService
{
    public function removeTokens(int $userId): void
    {
        PushToken::where('user_id', $userId)->delete();
    }
}
