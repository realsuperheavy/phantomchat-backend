<?php

namespace App\Console\Commands\Test;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Jobs\SendPushNotificationJob;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use App\Models\User;
use Illuminate\Console\Command;

class SendTestPushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:send-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends test push';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (User::get() as $user) {
            $value = new PushNotificationGeneral(
                'darkec',
                'hey man, what\'s up with you',
            );

            $value
                ->setReceiverId($user->getId())
                ->setOpenScreen(PushNotificationGeneral::SCREEN_MESSAGE)
                ->setBadge(1)
                ->setAdditionalData(
                    [
                        'conversation_id' => 1
                    ]
                );

            SendPushNotificationJob::dispatch($value);
        }
        return Command::SUCCESS;
    }
}
