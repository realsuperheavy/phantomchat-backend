<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Email\Infra\Value;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Value\SystemCommunicationValueInterface;

final class EmailSystemCommunicationValue implements SystemCommunicationValueInterface
{
    private string $toEmail;
    private ?string $fromEmail;
    private string $subject;
    private string $bladeView;
    private array $viewData;

    public function __construct(
        string $toEmail,
        string $subject,
        string $bladeView,
        array $viewData = [],
        ?string $fromEmail = null
    ) {
        $this->toEmail = $toEmail;
        $this->fromEmail = $fromEmail;
        $this->subject = $subject;
        $this->bladeView = $bladeView;
        $this->viewData = $viewData;
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBladeView(): string
    {
        return $this->bladeView;
    }

    public function getViewData(): array
    {
        return $this->viewData;
    }
}
