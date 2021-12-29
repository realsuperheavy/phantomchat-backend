<?php

namespace Tests\Feature\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\GetPushTokensService;
use App\Models\PushToken;
use Illuminate\Support\Facades\App;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class GetPushTokensServiceTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testGetPushTokensFromConversation()
    {
        $user = $this->getTestUser();
        $test1 = $this->getTest1User();

        $response = $this->getService()->getPushTokensFromConversation(
            1,
            $user->getId(),
            PushToken::TOKEN_TYPE_FIREBASE
        );

        $this->assertEquals(1, $response->count());
        /** @var PushToken $token */
        $token = $response->first();
        $this->assertEquals($test1->getId(), $token->getUserId());
        $this->assertEquals(PushToken::PLATFORM_IOS, $token->getPlatform());
        $this->assertEquals('token_xxx', $token->getToken());
        $this->assertEquals('device_xxx', $token->getDeviceId());
        $this->assertEquals(PushToken::TOKEN_TYPE_FIREBASE, $token->getTokenType());
    }

    public function testGetPushTokensByUser()
    {
        $user = $this->getTestUser();

        $response = $this->getService()->getPushTokensByUser(
            $user->getId(),
            PushToken::TOKEN_TYPE_FIREBASE
        );

        $this->assertEquals(1, $response->count());

        /** @var PushToken $token */
        $token = $response->first();
        $this->assertEquals($user->getId(), $token->getUserId());
        $this->assertEquals(PushToken::PLATFORM_IOS, $token->getPlatform());
        $this->assertEquals('token_xxx', $token->getToken());
        $this->assertEquals('device_xxx', $token->getDeviceId());
        $this->assertEquals(PushToken::TOKEN_TYPE_FIREBASE, $token->getTokenType());
    }

    private function getService(): GetPushTokensService
    {
        return App::make(GetPushTokensService::class);
    }
}
