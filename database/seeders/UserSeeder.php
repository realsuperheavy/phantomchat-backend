<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedTestUser();
        $this->seedMinimumUser();
        $this->seedRandomUser();
        $this->seedSystemUser();
    }

    private function seedTestUser()
    {
        $user = User::factory()
            ->state([
                'username' => 'test',
                'email' => 'test@test.com',

            ])->create();
    }

    private function seedMinimumUser()
    {
        $user = User::factory()
            ->state([
                'username' => 'min_user',
                'email' => 'minuser@test.com',

            ])->create();
    }

    private function seedRandomUser()
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = User::factory()
                ->state([
                    'username' => 'test'.$i,
                    'email' => "test$i@test.com",

                ])->create();
        }
    }

    private function seedSystemUser()
    {
        $user = User::factory()
        ->state([
            'username' => 'system',
            'email' => "system@noreply.com",

        ])->create();
    }
}
