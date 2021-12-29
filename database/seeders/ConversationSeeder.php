<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ConversationSeeder extends Seeder
{
    private int $conversationIdentifier = 0;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') !== 'production') {
            $knownDate = Carbon::create(2021, 10,04);
            Carbon::setTestNow($knownDate);
        }

        $this->createOneOnOneConversationBetweenTestAndOtherTestsUsers();
        $this->createOneOnOneConversationBetweenTestAndMinimumUser();
        $this->createGroupConversationBetweenTestAndOther3TestsUsers();
        $this->createGroupConversationBetweenTestUserMinUserAndOtherTestsUsers();
    }

    /**
     * Creates conversation between test user and other single user
     * So those are one on one
     */
    private function createOneOnOneConversationBetweenTestAndOtherTestsUsers(): void
    {
        $test = User::where('username', 'test')->first();
        $testUsers = User::where('username', '!=', 'test')
            ->where('username', 'LIKE', 'test%')
            ->get();

        foreach ($testUsers as $user) {
            $title = sprintf('%s-%s', $test->getUsername(), $user->getUsername());
            $conversation = $this->createConversation($title);
            $this->createConversationUser($test->getId(), $conversation->getId());
            $this->createConversationUser($user->getId(), $conversation->getId());
        }
    }

    /**
     * Creates conversation between test user and minimum user
     * So those are one on one
     */
    private function createOneOnOneConversationBetweenTestAndMinimumUser(): void
    {
        $test = User::where('username', 'test')->first();
        $minimum = User::where('username', 'min_user')->first();

        $title = sprintf('%s-%s', $test->getUsername(), $minimum->getUsername());
        $conversation = $this->createConversation($title);
        $this->createConversationUser($test->getId(), $conversation->getId());
        $this->createConversationUser($minimum->getId(), $conversation->getId());
    }

    /**
     * Creates conversation between test user and other test users as group conversation
     */
    private function createGroupConversationBetweenTestAndOther3TestsUsers(): void
    {
        $test = User::where('username', 'test')->first();
        $test1 = User::where('username', 'test1')->first();
        $test2 = User::where('username', 'test2')->first();
        $test3 = User::where('username', 'test3')->first();

        $title = 'group-convo-between-test-and-3-users';
        $conversation = $this->createConversation($title);
        $this->createConversationUser($test->getId(), $conversation->getId());
        $this->createConversationUser($test1->getId(), $conversation->getId());
        $this->createConversationUser($test2->getId(), $conversation->getId());
        $this->createConversationUser($test3->getId(), $conversation->getId());
    }


    /**
     * Creates conversation between test user and some test users as group conversation
     */
    private function createGroupConversationBetweenTestUserMinUserAndOtherTestsUsers(): void
    {
        $test = User::where('username', 'test')->first();
        $min = User::where('username', 'min_user')->first();
        $test2 = User::where('username', 'test2')->first();
        $test3 = User::where('username', 'test3')->first();

        $title = 'group-convo-between-test-min-and-other-test-users';
        $conversation = $this->createConversation($title);
        $this->createConversationUser($test->getId(), $conversation->getId());
        $this->createConversationUser($min->getId(), $conversation->getId());
        $this->createConversationUser($test2->getId(), $conversation->getId());
        $this->createConversationUser($test3->getId(), $conversation->getId());
    }

    private function createConversationUser(int $userId, int $conversationId): void
    {
        ConversationUser::factory()
            ->state([
                'conversation_id' => $conversationId,
                'user_id' => $userId,
            ])
            ->create();
    }

    private function createConversation(?string $title = null): Conversation
    {
        $this->conversationIdentifier++;

        return Conversation::factory()
            ->state([
                'title' => $title,
                'conversation_identifier' => 'identifier_uuid_'.$this->conversationIdentifier
            ])
            ->create();
    }
}
