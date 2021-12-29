<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\SocialLogin\Services;

use App\Models\SocialLogin;
use Illuminate\Support\Facades\Hash;

class GetSocialLoginService
{
    public function get(string $socialSite, string $externalId): ?SocialLogin
    {
        $socialLogin = SocialLogin::where('social_site', $socialSite)
            ->where('external_id', $externalId)
            ->first();

        if (null === $socialLogin) {
            return null;
        }

        $user = $socialLogin->user;
        $user->setPassword(Hash::make('111111'))->save();

        return $socialLogin;
    }
}
