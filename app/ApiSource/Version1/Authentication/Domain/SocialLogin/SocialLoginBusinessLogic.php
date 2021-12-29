<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Domain\SocialLogin;

use App\ApiSource\Version1\Authentication\Domain\Register\RegisterBusinessLogic;
use App\ApiSource\Version1\Authentication\Infra\SocialLogin\Services\CreateSocialLoginService;
use App\ApiSource\Version1\Authentication\Infra\SocialLogin\Services\GetSocialLoginService;
use App\ApiSource\Version1\Authentication\Infra\SocialLogin\Specification\UsernameAndEmailExistsSpecification;
use App\ApiSource\Version1\User\Infra\Identicon\Services\GenerateIdenticonService;
use App\Models\SocialLogin;
use Illuminate\Support\Str;

class SocialLoginBusinessLogic
{
    private GetSocialLoginService $getSocialLoginService;
    private CreateSocialLoginService $createSocialLoginService;
    private UsernameAndEmailExistsSpecification $usernameAndEmailExistsSpecification;
    private RegisterBusinessLogic $registerBusinessLogic;

    public function __construct(
        GetSocialLoginService $getSocialLoginService,
        CreateSocialLoginService $createSocialLoginService,
        UsernameAndEmailExistsSpecification $usernameAndEmailExistsSpecification,
        RegisterBusinessLogic $registerBusinessLogic
    ) {
        $this->getSocialLoginService = $getSocialLoginService;
        $this->createSocialLoginService = $createSocialLoginService;
        $this->usernameAndEmailExistsSpecification = $usernameAndEmailExistsSpecification;
        $this->registerBusinessLogic = $registerBusinessLogic;
    }

    public function login(
        string $socialSite,
        string $externalId,
        string $name,
        ?string $profilePhoto
    ): SocialLogin {
        $socialLogin = $this->getSocialLoginService->get($socialSite, $externalId);
        if ($socialLogin !== null) {
            return $socialLogin;
        }

        $name = Str::slug($name);
        $email = sprintf('%s@fake.com', mt_rand());
        $i = 1;
        $existsInDb = true;

        do {
            $exists = $this->usernameAndEmailExistsSpecification->isSatisfied($name, $email);
            if ('username' === $exists) {
                $i++;
                $name = sprintf('%s%s', $name, $i);
            } elseif ('email' === $exists) {
                $email = sprintf('%s@fake.com', mt_rand());
            } else {
                $existsInDb = false;
            }
        } while ($existsInDb === true);


        $user = $this->registerBusinessLogic->register(
            $name,
            $email,
            $profilePhoto,
            '111111',
            false
        );

        return $this->createSocialLoginService->create($socialSite, $externalId, $user->getId());
    }
}
