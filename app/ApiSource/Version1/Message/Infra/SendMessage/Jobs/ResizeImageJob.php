<?php

namespace App\ApiSource\Version1\Message\Infra\SendMessage\Jobs;

use App\ApiSource\Version1\ImageModification\Infra\ModifyImage\Services\ModifyImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResizeImageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 5;

    private ?string $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        ?string $filePath
    ) {
        $this->filePath = $filePath;
        $this->queue = 'post_send_message_queue';
    }

    public function handle(
        ModifyImageService $manipulateImageService
    ): bool {
        if (null === $this->filePath || filter_var($this->filePath, FILTER_VALIDATE_URL)) {
            return false;
        }

        $manipulateImageService
            ->createImage($this->filePath)
            ->resize(1200, 600)
            ->getImage()
            ->save(null, 60);

        return true;
    }
}
