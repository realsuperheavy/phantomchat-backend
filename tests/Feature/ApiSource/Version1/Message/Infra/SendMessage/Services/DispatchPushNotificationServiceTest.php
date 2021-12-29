<?php

namespace Tests\Feature\ApiSource\Version1\Message\Infra\SendMessage\Services;

use App\ApiSource\Version1\Message\Infra\SendMessage\Services\DispatchPushNotificationService;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Jobs\SendPushNotificationJob;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationGeneral;
use App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value\PushNotificationMessage;
use App\Models\Message;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Bus;
use Tests\FeatureTestCase;
use Tests\Traits\TestMessageTrait;
use Tests\Traits\TestUserTrait;

class DispatchPushNotificationServiceTest extends FeatureTestCase
{
    use TestUserTrait;
    use TestMessageTrait;

    public function testDispatchPushNotificationJob()
    {
        Bus::fake();
        $sender = $this->getTestUser();

        $lastMessage = new Message();
        $lastMessage
            ->setConversationId(1111)
            ->setBody('Some super cool body')
            ->setSenderId($sender->getId());

        $pushMessage = new PushNotificationMessage(
            $sender->getUsername(),
            $lastMessage->getBodyFormatted(),
            $lastMessage->getConversationId(),
            $sender->getId(),
        );

        $pushMessage
            ->setBadge(1)
            ->setAdditionalData(
                [
                    'conversation_id' => $lastMessage->getConversationId(),
                ]
            )
            ->setOpenScreen(PushNotificationGeneral::SCREEN_MESSAGE);

        $this->getService()->dispatchPushNotificationJob($lastMessage);

        Bus::assertDispatched(
            function (SendPushNotificationJob $job) use ($pushMessage) {
                /** @var PushNotificationMessage $value */
                $value = $job->getPushNotificationValue();
                return $value->getTitle() === $pushMessage->getTitle()
                    &&
                    $value->getBody() === $pushMessage->getBody()
                    &&
                    $value->getConversationId() === $pushMessage->getConversationId()
                    &&
                    $value->getSenderId() === $pushMessage->getSenderId()
                    &&
                    $value->getBadge() === $pushMessage->getBadge()
                    &&
                    $value->getAdditionalData() === $pushMessage->getAdditionalData()
                    &&
                    $value->getOpenScreen() === $pushMessage->getOpenScreen();
            }
        );
    }

    private function getService(): DispatchPushNotificationService
    {
        return App::make(DispatchPushNotificationService::class);
    }
}
