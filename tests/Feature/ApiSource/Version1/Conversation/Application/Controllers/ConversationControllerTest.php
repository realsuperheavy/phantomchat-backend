<?php

namespace Tests\Feature\ApiSource\Version1\Conversation\Application\Controllers;

use App\Models\Conversation;
use App\Models\ConversationUser;
use Tests\FeatureTestCase;
use Tests\Traits\TestConversationTrait;
use Tests\Traits\TestUserTrait;

class ConversationControllerTest extends FeatureTestCase
{
    use TestUserTrait;
    use TestConversationTrait;

    public function testFlowDeleteFetchCreateFetchConversation()
    {
        $test = $this->getTestUser();
        $test1 = $this->getTest1User();
        $referentConversation = $this->getConversationBetweenTwoUsers($test->getId(), $test1->getId());

        //1 Delete conversation
        $this
            ->actingAs($test)
            ->deleteJson('api/v1/conversation/' . $referentConversation->getId());

        //2 Fetch conversations
        $response = $this
            ->actingAs($test)
            ->getJson('api/v1/conversation');

        $response->assertOk();
        $decoded = $response->decodeResponseJson();
        $data = $decoded['data'];
        foreach ($data as $singleConversation) {
            //make sure that $referentConversation is not being returned
            $this->assertTrue((int)$singleConversation['id'] !== $referentConversation->getId());
        }

        //3 create the same conversation
        $this
            ->actingAs($test)
            ->postJson(
                'api/v1/conversation',
                [
                    'user_ids' => [$test1->getId()]
                ]
            );

        //4 Fetch conversations
        $response = $this
            ->actingAs($test)
            ->getJson('api/v1/conversation');

        $response->assertOk();
        $decoded = $response->decodeResponseJson();
        $data = $decoded['data'];
        $conversationFound = false;
        foreach ($data as $singleConversation) {
            //make sure that $referentConversation is returned
            if ((int)$singleConversation['id'] === $referentConversation->getId()) {
                $conversationFound = true;
            }
        }
        $this->assertTrue($conversationFound);
    }

    public function testCreateConversationWhenConversationDoesNotExist()
    {
        $user = $this->getTestUser();
        $randomUser = $this->newUser();

        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/conversation',
                [
                    'user_ids' => [$randomUser->getId()]
                ]
            );

        $lastConversation = Conversation::orderBy('id', 'DESC')->first();

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => $lastConversation->getId(),
                    'updated_at' => $lastConversation->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'conversation_identifier' => $lastConversation->getConversationIdentifier(),
                    'display_users' => [
                        [
                            'id' => $randomUser->getId(),
                            'username' => $randomUser->getUsername(),
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ],
                    ],
                ]
            ]
        );
    }

    public function testCreateConversationWhenConversationExists()
    {
        $test = $this->getTestUser();
        $test1 = $this->getTest1User();

        $response = $this
            ->actingAs($test)
            ->postJson(
                'api/v1/conversation',
                [
                    'user_ids' => [$test1->getId()]
                ]
            );

        $response->assertOk();
        $decoded = $response->decodeResponseJson();
        $this->assertEquals(1, $decoded['data']['id']);
    }

    public function testCreateConversationWithYourself()
    {
        $user = $this->getTestUser();
        $response = $this
            ->actingAs($user)
            ->postJson(
                'api/v1/conversation',
                [
                    'user_ids' => [$user->getId()]
                ]
            );


        $response->assertForbidden();
        $decoded = $response->decodeResponseJson();
        $this->assertEquals("You can't start a conversation with yourself.", $decoded['message']);
    }

    public function testGetConversations()
    {
        $user = $this->getTestUser();

        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/conversation');

        $response->assertOk();
        $decoded = $response->decodeResponseJson();
        $expectedData =
            [
                0 => [
                    "id" => 1,
                    "updated_at" => "2021-10-04 00:00:00",
                    "conversation_identifier" => "identifier_uuid_1",
                    "display_users" => [
                        [
                            "id" => 3,
                            "username" => "test1",
                            "profile_photo" => "https://dummyimage.com/200x200/0c3ee3/fff",
                        ],
                    ],
                ],
                1 => [
                    'id' => 2,
                    'updated_at' => '2021-10-04 00:00:00',
                    'conversation_identifier' => 'identifier_uuid_2',
                    'display_users' => [
                        [
                            'id' => 4,
                            'username' => 'test2',
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ],
                    ],
                ],
                2 => [
                    'id' => 3,
                    'updated_at' => '2021-10-04 00:00:00',
                    'conversation_identifier' => 'identifier_uuid_3',
                    'display_users' => [
                        [
                            'id' => 5,
                            'username' => 'test3',
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ],
                    ],
                ],
            ];

        $response->assertJsonStructure(
            [
                'data',
                'links',
                'meta'
            ]
        );

        $this->assertEquals($expectedData[0], $decoded['data'][0]);
        $this->assertEquals($expectedData[1], $decoded['data'][1]);
        $this->assertEquals($expectedData[2], $decoded['data'][2]);
    }


    public function testGetConversationById(): void
    {
        $user = $this->getTestUser();
        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/conversation/1');

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => 1,
                    'updated_at' => '2021-10-04 00:00:00',
                    'conversation_identifier' => 'identifier_uuid_1',
                    'display_users' => [
                        [
                            'id' => 3,
                            'username' => 'test1',
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ],
                    ],
                ],
            ],
        );
    }

    public function testGetDeletedConversationById(): void
    {
        $user = $this->getTestUser();
        $conversation = $this->getFirstConversationByUser($user->getId());

        //delete conversation
        $conversationUser = ConversationUser::where('user_id', $user->getId())
            ->where('conversation_id', $conversation->getId())
            ->first();
        $conversationUser->delete();

        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/conversation/1');

        $response->assertForbidden();
        $decoded = $response->decodeResponseJson();
        $this->assertEquals("You don't have access to this conversation.", $decoded['message']);
    }

    public function testGetGroupConversationById(): void
    {
        $conversation = Conversation::where('title', 'group-convo-between-test-and-3-users')->first();

        $user = $this->getTestUser();
        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/conversation/' . $conversation->getId());

        $response->assertOk();
        $response->assertExactJson(
            [
                'data' => [
                    'id' => 12,
                    'updated_at' => '2021-10-04 00:00:00',
                    'conversation_identifier' => 'identifier_uuid_12',
                    'display_users' => [
                        0 => [
                            'id' => 3,
                            'username' => 'test1',
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ],
                        1 => [
                            'id' => 4,
                            'username' => 'test2',
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ],
                        2 => [
                            'id' => 5,
                            'username' => 'test3',
                            'profile_photo' => 'https://dummyimage.com/200x200/0c3ee3/fff',
                        ]
                    ]
                ]
            ]
        );
    }

    public function testGetConversationByIdWhenIsNotAllowed(): void
    {
        $user = $this->newUser();
        $response = $this
            ->actingAs($user)
            ->getJson('api/v1/conversation/1');

        $response->assertForbidden();
        $decoded = $response->decodeResponseJson();
        $this->assertEquals("You don't have access to this conversation.", $decoded['message']);
    }

    public function testDeleteConversation(): void
    {
        $user = $this->getTestUser();
        $conversation = $this->getFirstConversationByUser($user->getId());

        $response = $this
            ->actingAs($user)
            ->deleteJson('api/v1/conversation/1');

        $response->assertOk();
        $conversationUser = ConversationUser::where('user_id', $user->getId())
            ->where('conversation_id', $conversation->getId())
            ->first();

        $this->assertNull($conversationUser);

        $conversationUser = ConversationUser::withTrashed()
            ->where('user_id', $user->getId())
            ->where('conversation_id', $conversation->getId())
            ->first();

        $this->assertNotNull($conversationUser->getDeletedAt());
    }

    public function testDeleteConversationYouAreNotPartOf(): void
    {
        $user = $this->newUser();
        $response = $this
            ->actingAs($user)
            ->deleteJson('api/v1/conversation/1');

        $response->assertForbidden();
        $decoded = $response->decodeResponseJson();
        $this->assertEquals('You are not part of this conversation', $decoded['message']);
    }
}
