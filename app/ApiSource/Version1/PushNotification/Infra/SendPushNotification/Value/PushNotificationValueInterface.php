<?php
declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value;

interface PushNotificationValueInterface
{

    public function getBody(): string;
    public function getTitle(): string;
    public function getReceiverId(): int;
    public function getAdditionalData(): array;
    public function getSound(): string;
    public function getBadge(): int;
    public function getIOSCategory(): string;
    public function getImage(): string;
    public function getVideo(): string;
    public function getOpenScreen(): string;
}
