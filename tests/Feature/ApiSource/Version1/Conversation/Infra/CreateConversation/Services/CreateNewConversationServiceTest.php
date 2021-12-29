<?php

namespace Tests\Feature\ApiSource\Version1\Conversation\Infra\CreateConversation\Services;

use App\ApiSource\Version1\Conversation\Infra\CreateConversation\Services\CreateNewConversationService;
use App\Models\Conversation;
use Illuminate\Support\Facades\App;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class CreateNewConversationServiceTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testBetween2Users()
    {
        $test = $this->getTestUser();
        $test1 = $this->getTest1User();

        /** @var Conversation $conversation */
        $conversation = $this->getService()->create(
            $test->getId(),
            [$test1->getId()]
        );

        $conversationUsers = $conversation->conversationUsers->pluck('user_id')->toArray();
        $this->assertCount(2, $conversationUsers);
        $this->assertTrue(in_array($test->getId(), $conversationUsers));
        $this->assertTrue(in_array($test1->getId(), $conversationUsers));
    }

    public function testBetweenMultipleUsers()
    {
        $test = $this->getTestUser();
        $test1 = $this->getTest1User();
        $test2 = $this->getByUsername('test2');
        $test3 = $this->getByUsername('test3');

        /** @var Conversation $conversation */
        $conversation = $this->getService()->create(
            $test->getId(),
            [$test1->getId(), $test2->getId(), $test3->getId()]
        );

        $conversationUsers = $conversation->conversationUsers->pluck('user_id')->toArray();
        $this->assertCount(4, $conversationUsers);
        $this->assertTrue(in_array($test->getId(), $conversationUsers));
        $this->assertTrue(in_array($test1->getId(), $conversationUsers));
        $this->assertTrue(in_array($test2->getId(), $conversationUsers));
        $this->assertTrue(in_array($test3->getId(), $conversationUsers));
    }

    private function getService(): CreateNewConversationService
    {
        return App::make(CreateNewConversationService::class);
    }
}
