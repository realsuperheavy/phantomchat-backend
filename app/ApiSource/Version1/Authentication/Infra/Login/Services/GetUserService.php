<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\Login\Services;

use App\Models\User;

class GetUserService
{
    public function getUser(string $username): ?User
    {
        return User::where('username', $username)->first();
    }
}
