<?php

namespace Tests\Feature\ApiSource\Version1\Conversation\Infra\GetConversation\Services;

use App\ApiSource\Version1\Conversation\Infra\GetConversation\Services\GetConversationByUsernameService;
use Illuminate\Support\Facades\App;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class GetConversationByUsernameServiceTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testGetConversationBetween2Users()
    {
        $test = $this->getTestUser();
        $test1 = $this->getByUsername('test1');

        $response = $this->getService()->getByUsernames($test->getId(), [$test1->getId()]);

        $this->assertEquals('test-test1', $response->getTitle());
    }

    public function testGetConversationBetween2UsersThatDoesNotExist()
    {
        $test = $this->getTestUser();
        $newUser = $this->newUser();

        $response = $this->getService()->getByUsernames($test->getId(), [$newUser->getId()]);

        $this->assertNull($response);
    }

    public function testGetConversationBetweenMultipleUsers()
    {
        $test = $this->getTestUser();
        $test1 = $this->getByUsername('test1');
        $test2 = $this->getByUsername('test2');
        $test3 = $this->getByUsername('test3');

        $response = $this->getService()->getByUsernames(
            $test->getId(),
            [$test1->getId(), $test2->getId(), $test3->getId()]
        );

        $this->assertNotNull($response);
        $this->assertEquals('group-convo-between-test-and-3-users', $response->getTitle());
    }


    /**
     * This is the case where we have conversation_id = 1 between user 1(test) and 3 (test1)
     * But also we have conversation_id = 12 between (1,3,4,5)
     * We should get back conversation_id=1 as a result
     */
    public function testGetConversationBetweenUserTestAndTest1()
    {
        $test = $this->getTestUser();
        $test1 = $this->getByUsername('test1');

        $response = $this->getService()->getByUsernames(
            $test->getId(),
            [$test1->getId()]
        );

        $this->assertNotNull($response);
        $this->assertEquals('test-test1', $response->getTitle());
    }

    public function testGetConversationBetweenTestUserMinUserAndOtherTestsUsers()
    {
        $test = $this->getTestUser();
        $test2 = $this->getByUsername('test2');
        $test3 = $this->getByUsername('test3');
        $min = $this->getMinimumUser();

        $response = $this->getService()->getByUsernames(
            $test->getId(),
            [$test2->getId(), $test3->getId(), $min->getId()]
        );

        $this->assertNotNull($response);
        $this->assertEquals('group-convo-between-test-min-and-other-test-users', $response->getTitle());
    }

    private function getService(): GetConversationByUsernameService
    {
        return App::make(GetConversationByUsernameService::class);
    }
}
