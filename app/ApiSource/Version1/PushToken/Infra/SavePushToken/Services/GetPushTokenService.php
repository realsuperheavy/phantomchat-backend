<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushToken\Infra\SavePushToken\Services;

use App\Models\PushToken;

class GetPushTokenService
{
    public function get(
        string $deviceId,
        string $platform,
        string $token,
        string $tokenType,
        int $userId
    ): PushToken {
        //first check if device id exists
        $pushToken = PushToken::where('device_id', $deviceId)
            ->where('user_id', $userId)
            ->where('platform', $platform)
            ->where('token_type', $tokenType)
            ->first();

        if (null !== $pushToken) {
            return $pushToken;
        }

        //check if token exists
        $pushToken = PushToken::where('token', $token)
            ->where('user_id', $userId)
            ->where('platform', $platform)
            ->where('token_type', $tokenType)
            ->first();

        if (null !== $pushToken) {
            return $pushToken;
        }

        //if we cannot find by token or by device id, insert new record in database
        return new PushToken();
    }
}
