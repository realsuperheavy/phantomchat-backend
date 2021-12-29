<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\PushNotification\Infra\SendPushNotification\Value;


class PushNotificationGeneral implements PushNotificationValueInterface
{
    public const DEFAULT_SOUND = 'default';
    public const SCREEN_HOME = 'home';
    public const SCREEN_MESSAGE = 'message';
    public const SCREEN_SETTINGS = 'settings';

    private string $body;
    private string $title;
    private int $receiverId = 0;
    private array $additionalData = [];
    private string $sound = self::DEFAULT_SOUND;
    private int $badge = 0;
    private string $iOSCategory = '';
    private string $image = '';
    private string $video = '';
    private string $openScreen = self::SCREEN_HOME;

    public function __construct(
        string $title,
        string $body
    ) {
        $this->title = $title;
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function setReceiverId(int $receiverId): self
    {
        $this->receiverId = $receiverId;
        return $this;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    public function setAdditionalData(array $additionalData): self
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function setSound(string $sound): self
    {
        $this->sound = $sound;
        return $this;
    }

    public function getBadge(): int
    {
        return $this->badge;
    }

    public function setBadge(int $badge): self
    {
        $this->badge = $badge;
        return $this;
    }

    public function getIOSCategory(): string
    {
        return $this->iOSCategory;
    }

    public function setIOSCategory(string $iOSCategory): self
    {
        $this->iOSCategory = $iOSCategory;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getVideo(): string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;
        return $this;
    }

    public function getOpenScreen(): string
    {
        return $this->openScreen;
    }

    public function setOpenScreen(string $openScreen): self
    {
        $this->openScreen = $openScreen;
        return $this;
    }
}
