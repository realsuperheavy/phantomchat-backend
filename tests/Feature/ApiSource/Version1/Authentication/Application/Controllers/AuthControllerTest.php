<?php

namespace Tests\Feature\ApiSource\Version1\Authentication\Application\Controllers;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\Models\SocialLogin;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class AuthControllerTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testRegister()
    {
        Event::fake();
        Storage::fake('public');

        $response = $this
            ->postJson(
                'api/v1/auth/registration',
                [
                    'username' => 'abc',
                    'email' => 'abc@g.com',
                ]
            );

        $photoName = sprintf('abc_%s.png', md5('abc'));

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [],
                'message' => 'We sent the login code to your email. Check spam folder also.'
            ]
        );

        Storage::disk('public')->assertExists('identicons/' . $photoName);
        Event::assertDispatched(SystemCommunicationEvent::class);
    }

    public function testLogin()
    {
        $user = $this->getTestUser();
        $pass = 123456;
        $user->setPassword(Hash::make($pass))->save();

        $response = $this
            ->postJson(
                'api/v1/auth/login',
                [
                    'username' => 'test',
                    'password' => 123456,
                    'device_id' => 'hhhaaa111'
                ]
            );

        $decoded = $response->decodeResponseJson();
        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' =>
                    [
                        'token',
                        'token_id',
                        'id',
                        'username',
                        'email',
                        'profile_photo',

                    ],
            ]
        );

        $this->assertEquals(1, $decoded['data']['id']);
        $this->assertEquals('test', $decoded['data']['username']);
        $this->assertEquals('test@test.com', $decoded['data']['email']);
        $this->assertEquals('https://dummyimage.com/200x200/0c3ee3/fff', $decoded['data']['profile_photo']);
        $this->assertEquals(null, $decoded['message']);


        $model = PersonalAccessToken::where('device_id', 'hhhaaa111')->first();
        $this->assertEquals('hhhaaa111', $model->device_id);
    }

    public function testRequestLoginCode()
    {
        Event::fake();

        $response = $this
            ->postJson(
                'api/v1/auth/request-login-code',
                [
                    'username' => 'test',
                ]
            );

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [],
                'message' => 'Login code has been sent to your email. Check the spam folder also.'
            ]
        );

        Event::assertDispatched(SystemCommunicationEvent::class);
    }

    public function testLogout()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/auth/logout',
                [
                    'token_id' => 1
                ]
            );

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [],
                'message' => null
            ]
        );
    }

    public function testSocialLogin()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/auth/social-login',
                [
                    'social_site' => 'snapchat',
                    'external_id' => 'abcde',
                    'name' => 'John Doe',
                    'profile_photo' => 'https://www.test.com/a.jpg'
                ]
            );

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'username' => 'john-doe'
                ],
                'message' => null
            ]
        );

        $socialLogin = SocialLogin::latest()->first();
        $this->assertEquals('snapchat', $socialLogin->getSocialSite());
        $this->assertEquals('abcde', $socialLogin->getExternalId());

        $user = $socialLogin->user;
        $this->assertEquals('john-doe', $user->getUsername());

        //send second request to confirm nothing new is created
        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/auth/social-login',
                [
                    'social_site' => 'snapchat',
                    'external_id' => 'abcde',
                    'name' => 'John Doe',
                    'profile_photo' => 'https://www.test.com/a.jpg'
                ]
            );
        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'username' => 'john-doe'
                ],
                'message' => null
            ]
        );
        $socialLoginTwo = SocialLogin::latest()->first();
        $this->assertTrue($socialLogin->getId() === $socialLoginTwo->getId());
    }
}
