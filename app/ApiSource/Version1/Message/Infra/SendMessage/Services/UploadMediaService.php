<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Message\Infra\SendMessage\Services;

use App\ApiSource\Version1\ImageModification\Infra\ModifyImage\Services\ModifyImageService;
use App\Models\Message;
use App\Traits\FileUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class UploadMediaService
{
    use FileUploadTrait;

    private ModifyImageService $manipulateImageService;

    public function __construct(
        ModifyImageService $manipulateImageService
    ) {
        $this->manipulateImageService = $manipulateImageService;
    }

    public function upload(
        string $messageType,
        ?UploadedFile $file,
        ?string $fileUrl
    ): ?string {
        if (null !== $file) {
            $date = Carbon::now()->format('Y-m-d');

            $path = $file->storeAs($this->getUploadDirectoryBasePath($date), $file->hashName());

            if (Message::TYPE_IMAGE === $messageType) {
                $this->manipulateImageService
                    ->createImage($path)
                    ->orientate()
                    ->getImage()
                    ->save(null, 70);
            }

            return $path;
        }

        if (null !== $fileUrl) {
            return $fileUrl;
        }

        return null;
    }
}
