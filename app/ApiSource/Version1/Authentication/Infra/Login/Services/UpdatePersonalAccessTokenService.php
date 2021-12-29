<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\Login\Services;

use Laravel\Sanctum\PersonalAccessToken;

class UpdatePersonalAccessTokenService
{
    public function updateToken(PersonalAccessToken $token, string $deviceId): void
    {
        $token->device_id = $deviceId;
        $token->save();
    }
}
