<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Domain\RequestLoginCode;

use App\ApiSource\Version1\Authentication\Infra\RequestLoginCode\Services\SendLoginCodeService;

class RequestLoginCodeBusinessLogic
{
    private SendLoginCodeService $sendLoginCodeService;

    public function __construct(
        SendLoginCodeService $sendLoginCodeService
    ) {
        $this->sendLoginCodeService = $sendLoginCodeService;
    }

    public function request(string $username): void
    {
        $this->sendLoginCodeService->sendCode($username);
    }
}
