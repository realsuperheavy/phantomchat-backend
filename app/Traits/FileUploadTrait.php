<?php

declare(strict_types=1);

namespace App\Traits;

trait FileUploadTrait
{
    private function getUploadDirectoryBasePath(string $date): string
    {
        return sprintf('post-media/%s', $date);
    }
}
