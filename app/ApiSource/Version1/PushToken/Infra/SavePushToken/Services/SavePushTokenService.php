<?php

namespace App\ApiSource\Version1\PushToken\Infra\SavePushToken\Services;

use App\Models\PushToken;

class SavePushTokenService
{
    public function save(
        PushToken $pushToken,
        string $deviceId,
        string $platform,
        string $token,
        string $tokenType,
        int $userId
    ): void {
        $pushToken
            ->setUserId($userId)
            ->setDeviceId($deviceId)
            ->setPlatform($platform)
            ->setToken($token)
            ->setTokenType($tokenType);

        $pushToken->save();
    }
}
