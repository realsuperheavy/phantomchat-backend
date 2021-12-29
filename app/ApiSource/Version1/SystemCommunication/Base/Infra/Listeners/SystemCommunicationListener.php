<?php

namespace App\ApiSource\Version1\SystemCommunication\Base\Infra\Listeners;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Exceptions\SystemCommunicationTypeNotSupportedException;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Services\SendEmailSystemCommunicationService;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Services\SendSocketSystemCommunicationService;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketSystemCommunicationValueInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class SystemCommunicationListener implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'system_notifications_queue';

    private SendEmailSystemCommunicationService $sendEmailSystemCommunicationService;
    private SendSocketSystemCommunicationService $sendSocketSystemCommunicationService;

    public function __construct(
        SendEmailSystemCommunicationService $sendEmailSystemCommunicationService,
        SendSocketSystemCommunicationService $sendSocketSystemCommunicationService
    ) {
        $this->sendEmailSystemCommunicationService = $sendEmailSystemCommunicationService;
        $this->sendSocketSystemCommunicationService = $sendSocketSystemCommunicationService;
    }

    /**
     * Handle the event.
     *
     * @param SystemCommunicationEvent $event
     * @return void
     */
    public function handle(SystemCommunicationEvent $event)
    {
        foreach ($event->communicationValues as $communicationValue) {
            if ($communicationValue instanceof EmailSystemCommunicationValue) {
                $this->sendEmailSystemCommunicationService->send($communicationValue);
            } else if ($communicationValue instanceof SocketSystemCommunicationValueInterface) {
                $this->sendSocketSystemCommunicationService->send($communicationValue);
            } else {
                throw new SystemCommunicationTypeNotSupportedException('System communication type not supported');
            }
            
        }
    }
}
