<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Base\Infra\Events;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Value\SystemCommunicationValueInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemCommunicationEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var SystemCommunicationValueInterface[]
     */
    public array $communicationValues;

    public function __construct(SystemCommunicationValueInterface ...$communicationValues)
    {
        $this->communicationValues = $communicationValues;
    }
}
