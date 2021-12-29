<?php

namespace Tests\Feature\ApiSource\Version1\PushToken\Application\Controllers;

use App\Models\PushToken;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class PushTokenControllerTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testCreateNewPushToken()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/push-token',
                [
                    'device_id' => 'test1',
                    'platform' => 'ios',
                    'token' => 'abc1'
                ]
            );

        $response->assertOk();

        $pushToken = PushToken::where('user_id', $user->getId())
            ->where('device_id', 'test1')
            ->where('platform', PushToken::PLATFORM_IOS)
            ->where('token', 'abc1')
            ->first();

        $this->assertNotNull($pushToken);
    }

    public function testCreateCheckByDeviceId()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/push-token',
                [
                    'device_id' => 'device_xxx',
                    'platform' => 'ios',
                    'token' => 'abc1'
                ]
            );

        $response->assertOk();

        $pushToken = PushToken::where('user_id', $user->getId())
            ->where('device_id', 'device_xxx')
            ->where('platform', PushToken::PLATFORM_IOS)
            ->where('token', 'abc1')
            ->first();

        $this->assertNotNull($pushToken);
    }

    public function testCreateCheckByTokenId()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/push-token',
                [
                    'device_id' => 'somedeviceid',
                    'platform' => 'ios',
                    'token' => 'token_xxx'
                ]
            );

        $response->assertOk();

        $pushToken = PushToken::where('user_id', $user->getId())
            ->where('device_id', 'somedeviceid')
            ->where('platform', PushToken::PLATFORM_IOS)
            ->where('token', 'token_xxx')
            ->first();

        $this->assertNotNull($pushToken);
    }
}
