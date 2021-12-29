<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Domain\UpdateUser;

use App\ApiSource\Version1\User\Infra\Identicon\Services\GenerateIdenticonService;
use App\ApiSource\Version1\User\Infra\UpdateUser\Services\UpdateUserService;
use App\Models\User;

class UpdateUserBusinessLogic
{
    private UpdateUserService $updateUserService;
    private GenerateIdenticonService $generateIdenticonService;

    public function __construct(
        UpdateUserService $updateUserService,
        GenerateIdenticonService $generateIdenticonService
    ) {
        $this->updateUserService = $updateUserService;
        $this->generateIdenticonService = $generateIdenticonService;
    }

    public function update(
        int $userId,
        ?string $username
    ): User {
        $profilePhotoPath = $this->generateIdenticonService->generateIdenticon($username);
        return $this->updateUserService->update(
            $userId,
            $username,
            $profilePhotoPath
        );
    }
}
