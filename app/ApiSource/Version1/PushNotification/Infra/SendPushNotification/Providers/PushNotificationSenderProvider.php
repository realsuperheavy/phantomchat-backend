<?php

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Providers;

use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\FirebasePushNotificationSenderService;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Services\PushNotificationSenderInterface;
use Illuminate\Support\ServiceProvider;

class PushNotificationSenderProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PushNotificationSenderInterface::class, FirebasePushNotificationSenderService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
