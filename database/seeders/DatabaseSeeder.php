<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUser();
        $this->seedConversation();
        $this->seedPushToken();

        Model::reguard();
        //reset time to now
        Carbon::setTestNow();
    }

    private function seedUser(): void
    {
        $this->call(
            [
                UserSeeder::class,
            ]
        );
    }

    private function seedConversation(): void
    {
        $this->call(
            [
                ConversationSeeder::class,
            ]
        );
    }

    private function seedPushToken(): void
    {
        $this->call(
            [
                PushTokenSeeder::class,
            ]
        );
    }
}
