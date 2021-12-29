<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Domain\Login;

use App\ApiSource\Version1\Authentication\Infra\Login\Services\GetUserService;
use App\ApiSource\Version1\Authentication\Infra\Login\Services\ResetPasswordService;
use App\ApiSource\Version1\Authentication\Infra\Login\Services\UpdatePersonalAccessTokenService;
use App\ApiSource\Version1\Exception\GenericException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginBusinessLogic
{
    private GetUserService $getUserService;
    private ResetPasswordService $resetPasswordService;
    private UpdatePersonalAccessTokenService $updatePersonalAccessTokenService;

    public function __construct(
        GetUserService $getUserService,
        ResetPasswordService $resetPasswordService,
        UpdatePersonalAccessTokenService $updatePersonalAccessTokenService
    ) {
        $this->getUserService = $getUserService;
        $this->resetPasswordService = $resetPasswordService;
        $this->updatePersonalAccessTokenService = $updatePersonalAccessTokenService;
    }

    public function login(string $username, string $password, string $deviceId): array
    {
        $user = $this->getUserService->getUser($username);

        if (null === $user) {
            throw new GenericException(
                __('v1/auth.login.user_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        if (!Hash::check($password, $user->getPassword())) {
            throw new GenericException(
                __('v1/auth.login.invalid_login_code'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->resetPasswordService->reset($username);
        $token = $user->createToken($username . time());
        $plainTextToken = $token->plainTextToken;

        $plainTextToken = explode('|', $plainTextToken);
        $this->updatePersonalAccessTokenService->updateToken($token->accessToken, $deviceId);

        return [
            'token_id' => (int)$plainTextToken[0], //token_id
            'token' => $plainTextToken[1], //token (string)
            'user' => $user,
        ];
    }
}
