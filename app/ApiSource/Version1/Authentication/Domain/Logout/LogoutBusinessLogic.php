<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Domain\Logout;

use App\ApiSource\Version1\Authentication\Infra\Logout\Services\RevokeUserTokenService;

class LogoutBusinessLogic
{
    private RevokeUserTokenService $revokeUserTokenService;

    public function __construct(
        RevokeUserTokenService $revokeUserTokenService
    ) {
        $this->revokeUserTokenService = $revokeUserTokenService;
    }

    public function logout(int $tokenId, int $userId): void
    {
        $this->revokeUserTokenService->revoke($tokenId, $userId);
    }
}
