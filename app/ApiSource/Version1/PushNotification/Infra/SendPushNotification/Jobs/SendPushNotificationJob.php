<?php

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Jobs;

use App\ApiSource\Version1\PushNotification\Domain\SendPushNotification\SendPushNotificationBusinessLogic;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationValueInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private PushNotificationValueInterface $pushNotificationValue;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;


    /**
     * This is used for passing data to job
     */
    public function __construct(
        PushNotificationValueInterface $pushNotificationValue
    ) {
        $this->pushNotificationValue = $pushNotificationValue;
        $this->queue  = 'push_notifications_queue';
    }

    /**
     * Execute the job.
     * Injecting dependencies
     * @return void
     */
    public function handle(
        SendPushNotificationBusinessLogic $sendPushNotificationBusinessLogic
    ) {
        if (false === config('app.send_push')) {
            return;
        }

        $sendPushNotificationBusinessLogic->sendPushNotification($this->pushNotificationValue);
    }

    public function getPushNotificationValue(): PushNotificationValueInterface
    {
        return $this->pushNotificationValue;
    }
}
