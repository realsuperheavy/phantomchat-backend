<?php

namespace App\Providers;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Listeners\SystemCommunicationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SystemCommunicationEvent::class => [
            SystemCommunicationListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
