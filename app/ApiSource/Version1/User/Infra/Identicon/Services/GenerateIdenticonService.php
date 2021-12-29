<?php

declare(strict_types=1);

namespace App\ApiSource\Version1\User\Infra\Identicon\Services;

use Identicon\Identicon;
use Illuminate\Support\Facades\Storage;

class GenerateIdenticonService
{
    public function generateIdenticon(string $username): string
    {
        $identicon = new Identicon();
        $imageDataUri = $identicon->getImageDataUri($username);

        list($type, $imageDataUri) = explode(';', $imageDataUri);
        list(, $imageDataUri)      = explode(',', $imageDataUri);
        $imageDataUri = base64_decode($imageDataUri);

        $imagePath = sprintf('identicons/%s_%s.png', $username, md5($username));
        Storage::put($imagePath, $imageDataUri);
        return $imagePath;
    }
}
