<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\SocialLogin\Services;

use App\Models\SocialLogin;

class CreateSocialLoginService
{
    public function create(string $socialSite, string $externalId, int $userId): SocialLogin
    {
        $socialLogin = new SocialLogin();
        $socialLogin
            ->setUserId($userId)
            ->setExternalId($externalId)
            ->setSocialSite($socialSite)
            ->save();

        return $socialLogin;
    }
}
