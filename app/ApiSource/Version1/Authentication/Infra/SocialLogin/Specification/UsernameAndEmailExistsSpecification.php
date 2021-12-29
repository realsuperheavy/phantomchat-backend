<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\SocialLogin\Specification;

use App\Models\User;
use Illuminate\Database\Query\Builder;

class UsernameAndEmailExistsSpecification
{
    public function isSatisfied(string $username, string $email): string
    {
        $count = User::where('username', $username)->count();

        if ($count > 0) {
            return 'username';
        }

        $count = User::where('email', $email)->count();

        if ($count > 0) {
            return 'email';
        }

        return '';
    }
}
