<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushToken\Domain\SavePushToken;

use App\ApiSource\Version1\PushToken\Infra\SavePushToken\Services\GetPushTokenService;
use App\ApiSource\Version1\PushToken\Infra\SavePushToken\Services\SavePushTokenService;

class SavePushTokenBusinessLogic
{
    private GetPushTokenService $getPushTokenService;
    private SavePushTokenService $savePushTokenService;

    public function __construct(
        GetPushTokenService $getPushTokenService,
        SavePushTokenService $savePushTokenService
    ) {
        $this->getPushTokenService = $getPushTokenService;
        $this->savePushTokenService = $savePushTokenService;
    }

    public function save(
        string $deviceId,
        string $platform,
        string $token,
        string $tokenType,
        int $userId
    ): void {
        $pushToken = $this->getPushTokenService->get(
            $deviceId,
            $platform,
            $token,
            $tokenType,
            $userId
        );

        $this->savePushTokenService->save(
            $pushToken,
            $deviceId,
            $platform,
            $token,
            $tokenType,
            $userId
        );
    }
}
