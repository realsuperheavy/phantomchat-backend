<?php

namespace Tests\Feature\ApiSource\Version1\User\Application\Controllers;

use Illuminate\Support\Facades\Storage;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class UserControllerTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testGetUserByUsername()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/user/' . $user->getUsername());

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => 1,
                    'username' => 'test',
                    'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                ]
            ]
        );
    }

    public function testGetUserByUsernameWhenNotFound()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/user/blabla');

        $response->assertNotFound();
        $response->assertJsonFragment(
            [
                'message' => 'User with this username does not exist.',
            ]
        );
    }

    public function testGetMe()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/user/me');

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => 1,
                    'email' => 'test@test.com',
                    'username' => 'test',
                    'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                ]
            ]
        );
    }

    public function testDelete()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->deleteJson('api/v1/user');

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [],
                'message' => 'Account has been deleted.'
            ]
        );
    }

    public function testUpdate()
    {
        Storage::fake('public');

        $user = $this->getTestUser();
        $photoName = sprintf('new_username_%s.png', md5('new_username'));

        $response = $this
            ->actingAs($user)
            ->patchJson(
                'api/v1/user',
                [
                    'username' => 'new_username'
                ]
            );

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => 1,
                    'email' => 'test@test.com',
                    'username' => 'new_username',
                    'profile_photo' => '/storage/identicons/' . $photoName,
                ],
            ]
        );

        Storage::disk('public')->assertExists('identicons/' . $photoName);
    }

    public function testSearch()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/user/search?username=tes');

        $response->assertOk();
        $decoded = $response->decodeResponseJson();
        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'username',
                        'profile_photo'
                    ],
                ]
            ]
        );

        $this->assertCount(10, $decoded['data']);
        foreach ($decoded['data'] as $data) {
            $this->assertFalse($data['username'] === 'test');
        }
    }
}
