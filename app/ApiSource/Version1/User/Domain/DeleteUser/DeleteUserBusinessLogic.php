<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Domain\DeleteUser;

use App\ApiSource\Version1\User\Infra\DeleteUser\Services\AnonymizeUserDataService;
use App\ApiSource\Version1\User\Infra\DeleteUser\Services\DeleteUserService;
use App\ApiSource\Version1\User\Infra\DeleteUser\Services\RemovePushTokensService;

class DeleteUserBusinessLogic
{
    private AnonymizeUserDataService $anonymizeUserDataService;
    private DeleteUserService $deleteUserService;
    /**
     * @var RemovePushTokensService
     */
    private RemovePushTokensService $removePushTokensService;

    public function __construct(
        AnonymizeUserDataService $anonymizeUserDataService,
        DeleteUserService $deleteUserService,
        RemovePushTokensService $removePushTokensService
    ) {
        $this->anonymizeUserDataService = $anonymizeUserDataService;
        $this->deleteUserService = $deleteUserService;
        $this->removePushTokensService = $removePushTokensService;
    }

    public function delete(int $userId): void
    {
        $this->anonymizeUserDataService->anonymize($userId);
        $this->removePushTokensService->removeTokens($userId);

        //we don't want to actually delete user
        //$this->deleteUserService->delete($userId);
    }
}
