<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\Message\Infra\SendMessage\Services;

use App\Models\Message;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class GetMessageTypeService
{
    public function getMessageType(?UploadedFile $file, ?string $fileUrl): string
    {
        if (null !== $file) {
            $imageExtensions = ['jpg', 'jpeg', 'gif', 'bmp', 'png'];
            $extension = Str::lower($file->getClientOriginalExtension());

            if (in_array($extension, $imageExtensions)) {
                return Message::TYPE_IMAGE;
            }

            return Message::TYPE_VIDEO;
        }

        if (null !== $fileUrl) {
            $fileUrlExtension = explode('.', $fileUrl);
            $fileUrlExtension = end($fileUrlExtension);
            if (Message::TYPE_GIF === $fileUrlExtension) {
                return Message::TYPE_GIF;
            }
        }

        return Message::TYPE_TEXT;
    }
}
