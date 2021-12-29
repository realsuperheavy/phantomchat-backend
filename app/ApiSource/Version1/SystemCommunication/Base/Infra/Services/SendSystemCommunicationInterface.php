<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Base\Infra\Services;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Value\SystemCommunicationValueInterface;

interface SendSystemCommunicationInterface
{
    public function send(SystemCommunicationValueInterface $systemCommunicationValue): void;
}
