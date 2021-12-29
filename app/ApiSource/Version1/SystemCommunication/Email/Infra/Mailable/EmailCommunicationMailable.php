<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\SystemCommunication\Email\Infra\Mailable;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailCommunicationMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;
    public string $bladeView;
    public $viewData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        string $subject,
        string $bladeView,
        array $viewData
    ) {
        $this->subject = $subject;
        $this->bladeView = $bladeView;
        $this->viewData = $viewData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view($this->bladeView)
            ->with($this->viewData);
    }
}
