<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;

trait UserTrait
{
    public function getSystemUser(): User
    {
        return User::where('username', 'system')->first();
    }
}
