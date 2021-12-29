<?php

namespace Tests\Feature\ApiSource\Version1\Conversation\Infra\GetConversation\Specification;

use App\ApiSource\Version1\Conversation\Infra\GetConversation\Specification\CanUserAccessConversationSpecification;
use Illuminate\Support\Facades\App;
use Tests\FeatureTestCase;
use Tests\Traits\TestConversationTrait;
use Tests\Traits\TestUserTrait;

class CanUserAccessConversationSpecificationTest extends FeatureTestCase
{
    use TestUserTrait;
    use TestConversationTrait;

    public function testWithSystemUser()
    {
        $response = $this->getService()->isSatisfied(1, $this->getSystemUser()->getId());

        $this->assertTrue($response);
    }

    public function testWhenUserDoesNotHaveAccess()
    {
        $response = $this->getService()->isSatisfied(1, $this->newUser()->getId());

        $this->assertFalse($response);
    }

    public function testWhenUserDoHaveAccess()
    {
        $user = $this->getTestUser();
        $conversation = $this->getFirstConversationByUser($user->getId());

        $response = $this->getService()->isSatisfied($conversation->getId(), $user->getId());

        $this->assertTrue($response);
    }

    private function getService(): CanUserAccessConversationSpecification
    {
        return App::make(CanUserAccessConversationSpecification::class);
    }
}
