<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\Login\Services;

use App\Models\User;

class ResetPasswordService
{
    public function reset(string $username): void
    {
        $user = User::where('username', $username)->first();
        $user->setPassword(null)->save();
    }
}
