<?php

namespace Tests\Feature\ApiSource\Version1\Authentication\Infra\Register\Services;

use App\ApiSource\Version1\Authentication\Infra\Register\Services\RegisterUserService;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Tests\FeatureTestCase;

class RegisterUserServiceTest extends FeatureTestCase
{
    public function testShouldSendEmail()
    {
        Event::fake();

        $response = $this->getService()->register(
            'username',
            'emai@am.com',
            'path-to-profile-pic',
            '111111',
            true
        );

        Event::assertDispatched(
            function (SystemCommunicationEvent $event) {
                /** @var EmailSystemCommunicationValue $notification */
                $notification = $event->communicationValues[0];

                return $notification->getToEmail() === "emai@am.com"
                    &&
                    $notification->getFromEmail() === null
                    &&
                    $notification->getSubject() === "Login code for Laravel"
                    &&
                    $notification->getBladeView() === "api.v1.email.auth.registration"
                    &&
                    $notification->getViewData() === [
                        "username" => "username",
                        "code" => "111111",
                    ];
            }
        );
    }

    public function testWhenPasswordIsNotSet()
    {
        $user = $this->getService()->register(
            'username',
            'emai@am.com',
            'path-to-profile-pic.jpg',
            null,
            false
        );

        $this->assertEquals('username', $user->getUsername());
        $this->assertEquals('emai@am.com', $user->getEmail());
        $this->assertEquals('path-to-profile-pic.jpg', $user->getProfilePhotoPath());
        $this->assertEquals('http://phantomchat.loc/storage/path-to-profile-pic.jpg', $user->getProfilePhotoUrl());
    }

    public function testWhenPasswordIsSet()
    {
        $user = $this->getService()->register(
            'username',
            'emai@am.com',
            'path-to-profile-pic.jpg',
            '111111',
            false
        );

        $this->assertEquals('username', $user->getUsername());
        $this->assertEquals('emai@am.com', $user->getEmail());
        $this->assertEquals('path-to-profile-pic.jpg', $user->getProfilePhotoPath());
        $this->assertEquals('http://phantomchat.loc/storage/path-to-profile-pic.jpg', $user->getProfilePhotoUrl());
    }

    private function getService(): RegisterUserService
    {
        return App::make(RegisterUserService::class);
    }
}
