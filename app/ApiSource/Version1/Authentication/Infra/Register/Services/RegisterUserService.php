<?php

namespace App\ApiSource\Version1\Authentication\Infra\Register\Services;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    public function register(
        string $username,
        string $email,
        string $profilePhotoPath,
        ?string $password = null,
        bool $shouldSendEmail = true
    ): User {
        if (null === $password) {
            $password = (string)mt_rand(100000, 999999);
        }

        $user = new User();
        $user
            ->setEmail($email)
            ->setUsername($username)
            ->setPassword(Hash::make($password))
            ->setProfilePhotoPath($profilePhotoPath);

        $user->save();

        if (true === $shouldSendEmail) {
            SystemCommunicationEvent::dispatch(
                $this->prepareEmail($email, $username, $password)
            );
        }

        return $user;
    }

    private function prepareEmail(string $email, string $username, string $code): EmailSystemCommunicationValue
    {
        $subject = __('v1/auth.registration.registration_email_code_subject');
        $data = [
            'username' => $username,
            'code' => $code
        ];

        return new EmailSystemCommunicationValue(
            $email,
            $subject,
            'api.v1.email.auth.registration',
            $data
        );
    }
}
