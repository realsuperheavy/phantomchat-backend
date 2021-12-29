<?php

namespace Tests\Feature\ApiSource\Version1\Conversation\Infra\GetUserConversations\Services;

use App\ApiSource\Version1\Conversation\Infra\GetUserConversations\Services\GetConversationsFromDatabaseService;
use App\Models\Conversation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\FeatureTestCase;
use Tests\Traits\TestUserTrait;

class GetConversationsFromDatabaseServiceTest extends FeatureTestCase
{
    use TestUserTrait;

    public function testGetConversationByTest1User()
    {
        $test1 = $this->getTest1User();
        $conversations = $this->getService()->getConversations($test1->getId());

        $this->assertEquals(2, $conversations->count());
        $myUserCount = 0;

        /** @var Conversation $conversation */
        foreach ($conversations as $conversation) {
            $conversation->load('users');
            foreach ($conversation->users as $user) {
                if ($user->getId() === $test1->getId()) {
                    $myUserCount++;
                }
            }
        }

        $this->assertEquals(2, $myUserCount);
    }

    public function testGetConversationByTestUser()
    {
        Config::set('pagination.per_page', 100);
        $test = $this->getTestUser();
        $conversations = $this->getService()->getConversations($test->getId());

        $this->assertEquals(13, $conversations->count());
        $myUserCount = 0;

        /** @var Conversation $conversation */
        foreach ($conversations as $conversation) {
            $conversation->load('users');
            foreach ($conversation->users as $user) {
                if ($user->getId() === $test->getId()) {
                    $myUserCount++;
                }
            }
        }

        $this->assertEquals(13, $myUserCount);
    }

    private function getService(): GetConversationsFromDatabaseService
    {
        return App::make(GetConversationsFromDatabaseService::class);
    }
}
