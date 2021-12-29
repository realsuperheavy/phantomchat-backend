<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Value\SystemCommunicationValueInterface;
use App\Models\Message;

final class SocketChatMessageSystemCommunicationValue implements SystemCommunicationValueInterface,
                                                                 SocketSystemCommunicationValueInterface
{
    private Message $message;

    public function __construct(
        Message $message
    ) {
        $this->message = $message;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
