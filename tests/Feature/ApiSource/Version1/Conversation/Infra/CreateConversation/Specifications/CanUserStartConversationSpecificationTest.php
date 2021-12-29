<?php

namespace Tests\Feature\ApiSource\Version1\Conversation\Infra\CreateConversation\Specifications;

use App\ApiSource\Version1\Conversation\Infra\CreateConversation\Specifications\CanUserStartConversationSpecification;
use Illuminate\Support\Facades\App;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class CanUserStartConversationSpecificationTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testUserWantsToSendMessageToHimself()
    {
        $test = $this->getTestUser();
        $response = $this->getService()->isSatisfied($test->getId(), [$test->getId()]);
        $this->assertFalse($response);
    }


    public function testUserSendsMessageToMultipleUsers()
    {
        $test = $this->getTestUser();
        $test1 = $this->getByUsername('test1');
        $test2 = $this->getByUsername('test2');

        $response = $this->getService()->isSatisfied(
            $test->getId(),
            [$test->getId(), $test1->getId(), $test2->getId()]
        );
        $this->assertTrue($response);
    }

    public function testUserSendsMessageToOneUser()
    {
        $test = $this->getTestUser();
        $test2 = $this->getByUsername('test2');

        $response = $this->getService()->isSatisfied($test->getId(), [$test2->getId()]);
        $this->assertTrue($response);
    }

    private function getService(): CanUserStartConversationSpecification
    {
        return App::make(CanUserStartConversationSpecification::class);
    }
}
