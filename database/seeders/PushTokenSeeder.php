<?php

namespace Database\Seeders;

use App\Models\PushToken;
use App\Models\User;
use Illuminate\Database\Seeder;

class PushTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        foreach (User::get() as $user) {
            $pushToken = new PushToken();
            $pushToken
                ->setPlatform(PushToken::PLATFORM_IOS)
                ->setToken('token_xxx')
                ->setUserId($user->getId())
                ->setDeviceId('device_xxx')
                ->setTokenType(PushToken::TOKEN_TYPE_FIREBASE)
                ->save()
            ;
        }
    }
}
