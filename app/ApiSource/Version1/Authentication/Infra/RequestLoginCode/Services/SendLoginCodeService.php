<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Authentication\Infra\RequestLoginCode\Services;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SendLoginCodeService
{
    public function sendCode(string $username): User
    {
        $user = User::where('username', $username)->firstOrFail();
        $password = (string)mt_rand(100000, 999999);
        $user->setPassword(Hash::make($password))->save();

        SystemCommunicationEvent::dispatch(
            $this->prepareEmail($user->getEmail(), $username, $password)
        );

        return $user;
    }

    private function prepareEmail(string $email, string $username, string $code): EmailSystemCommunicationValue
    {
        $subject = __('v1/auth.request_login_code.login_code_email_code_subject');
        $data = [
            'username' => $username,
            'code' => $code
        ];

        return new EmailSystemCommunicationValue(
            $email,
            $subject,
            'api.v1.email.auth.login_code',
            $data
        );
    }
}
