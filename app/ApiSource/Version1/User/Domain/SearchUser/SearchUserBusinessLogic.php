<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Domain\SearchUser;

use App\ApiSource\Version1\User\Infra\SearchUser\Services\SearchUserService;
use Illuminate\Database\Eloquent\Collection;

class SearchUserBusinessLogic
{
    private SearchUserService $searchUserService;

    public function __construct(
        SearchUserService $searchUserService
    ) {
        $this->searchUserService = $searchUserService;
    }

    public function search(string $username, int $currentUserId): Collection
    {
        return $this->searchUserService->search($username, $currentUserId);
    }
}
