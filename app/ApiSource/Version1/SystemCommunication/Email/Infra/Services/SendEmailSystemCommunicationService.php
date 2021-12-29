<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Email\Infra\Services;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Services\SendSystemCommunicationInterface;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Value\SystemCommunicationValueInterface;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Mailable\EmailCommunicationMailable;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use Illuminate\Support\Facades\Mail;

class SendEmailSystemCommunicationService implements SendSystemCommunicationInterface
{
    /**
     * @param EmailSystemCommunicationValue $communicationValue
     */
    public function send(SystemCommunicationValueInterface $communicationValue): void
    {
        $mail = new EmailCommunicationMailable(
            $communicationValue->getSubject(),
            $communicationValue->getBladeView(),
            $communicationValue->getViewData()
        );

        Mail::to($communicationValue->getToEmail())->send($mail);
    }
}
