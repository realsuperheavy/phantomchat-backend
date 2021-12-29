<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Domain\Register;

use App\ApiSource\Version1\Authentication\Infra\Register\Services\RegisterUserService;
use App\ApiSource\Version1\User\Infra\Identicon\Services\GenerateIdenticonService;
use App\Models\User;

class RegisterBusinessLogic
{
    private RegisterUserService $registerUserService;
    private GenerateIdenticonService $generateIdenticonService;

    public function __construct(
        GenerateIdenticonService $generateIdenticonService,
        RegisterUserService $registerUserService
    ) {
        $this->registerUserService = $registerUserService;
        $this->generateIdenticonService = $generateIdenticonService;
    }

    public function register(
        string $username,
        string $email,
        ?string $profilePhoto = null,
        ?string $password = null,
        bool $shouldSendEmail = true
    ): User {
        if (null === $profilePhoto) {
            $profilePhoto = $this->generateIdenticonService->generateIdenticon($username);
        }

        return $this->registerUserService->register(
            $username,
            $email,
            $profilePhoto,
            $password,
            $shouldSendEmail
        );
    }
}
