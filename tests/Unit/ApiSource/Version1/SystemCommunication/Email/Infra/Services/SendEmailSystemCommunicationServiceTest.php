<?php

namespace Tests\Unit\ApiSource\Version1\SystemCommunication\Email\Infra\Services;

use App\ApiSource\Version1\SystemCommunication\Email\Infra\Mailable\EmailCommunicationMailable;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Services\SendEmailSystemCommunicationService;
use App\ApiSource\Version1\SystemCommunication\Email\Infra\Value\EmailSystemCommunicationValue;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\TestCase;

class SendEmailSystemCommunicationServiceTest extends TestCase
{

    public function testSend()
    {
        Mail::fake();

        $value = new EmailSystemCommunicationValue(
            'test@email.com',
            'My subject',
            'views.email.test',
            ['test' => 111]
        );

        $this->getService()->send($value);

        Mail::assertSent(
            EmailCommunicationMailable::class,
            function (EmailCommunicationMailable $mail) {
                return $mail->hasTo('test@email.com') &&
                    $mail->subject === 'My subject' &&
                    $mail->bladeView === 'views.email.test' &&
                    $mail->viewData === ['test' => 111];
            }
        );
    }

    private function getService(): SendEmailSystemCommunicationService
    {
        return new SendEmailSystemCommunicationService();
    }
}
