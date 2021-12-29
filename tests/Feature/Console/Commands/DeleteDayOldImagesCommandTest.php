<?php

namespace Tests\Feature\Console\Commands;

use App\Traits\FileUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\FeatureTestCase;

class DeleteDayOldImagesCommandTest extends FeatureTestCase
{
    use FileUploadTrait;

    public function testDeleteFolder()
    {
        $knowDate = Carbon::create(2021, 12, 29, 0, 0, 0);
        Carbon::setTestNow($knowDate);

        $yesterday = '2021-12-28';
        $file = UploadedFile::fake()->create('test.jpg', 10);
        $basePath = $this->getUploadDirectoryBasePath($yesterday);

        Storage::fake('public');
        $filePath = Storage::putFile($basePath, $file);
        Storage::disk('public')->assertExists($filePath);

        $this->artisan('message:delete-images')
            ->expectsOutput('Directory deleted');

        Storage::disk('public')->assertMissing($filePath);
    }

    public function testFolderNotDeleted()
    {
        $knowDate = Carbon::create(2021, 12, 29, 0, 0, 0);
        Carbon::setTestNow($knowDate);

        $file = UploadedFile::fake()->create('test.jpg', 10);
        $basePath = $this->getUploadDirectoryBasePath($knowDate->format('Y-m-d'));

        Storage::fake('public');
        $filePath = Storage::putFile($basePath, $file);
        Storage::disk('public')->assertExists($filePath);

        $this->artisan('message:delete-images')
            ->expectsOutput('Directory not deleted');

        Storage::disk('public')->assertExists($filePath);
    }
}
