<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Socket\Infra\Services;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Exceptions\SystemCommunicationTypeNotSupportedException;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Services\SendSystemCommunicationInterface;
use App\ApiSource\Version1\SystemCommunication\Base\Infra\Value\SystemCommunicationValueInterface;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Events\SocketChatMessageEvent;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketChatMessageSystemCommunicationValue;

class SendSocketSystemCommunicationService implements SendSystemCommunicationInterface
{
    /**
     * @param SocketChatMessageSystemCommunicationValue $communicationValue
     */
    public function send(SystemCommunicationValueInterface $communicationValue): void
    {
        switch (true) {
            case ($communicationValue instanceof SocketChatMessageSystemCommunicationValue):
                SocketChatMessageEvent::dispatch($communicationValue);
                break;
            default:
                throw new SystemCommunicationTypeNotSupportedException('Socket notification type not supported');
        }
    }
}
