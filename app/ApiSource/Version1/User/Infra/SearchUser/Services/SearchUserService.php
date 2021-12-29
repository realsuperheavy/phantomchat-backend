<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Infra\SearchUser\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class SearchUserService
{
    public function search(string $username, int $currentUserId): Collection
    {
        return User::where('username', 'LIKE', $username.'%')
            ->where('id', '!=', $currentUserId)
            ->get();
    }
}
