<?php

namespace Tests\Traits;

use App\Models\User;

trait TestUserTrait
{
    private function getTestUser(): User
    {
        return User::where('username', 'test')->first();
    }

    private function getMinimumUser(): User
    {
        return User::where('username', 'min_user')->first();
    }

    private function getTest1User(): User
    {
        return User::where('username', 'test1')->first();
    }

    private function getByUsername(string $username): User
    {
        return User::where('username', $username)->first();
    }

    private function getSystemUser(): User
    {
        return User::where('username', 'system')->first();
    }

    private function newUser(): User
    {
        $user = User::factory()->create();
        return $user;
    }
}
