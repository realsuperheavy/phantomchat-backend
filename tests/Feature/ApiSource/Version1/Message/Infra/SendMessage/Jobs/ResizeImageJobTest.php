<?php

namespace Tests\Feature\ApiSource\Version1\Message\Infra\SendMessage\Jobs;

use App\ApiSource\Version1\ImageModification\Infra\ModifyImage\Services\ModifyImageService;
use App\ApiSource\Version1\Message\Infra\SendMessage\Jobs\ResizeImageJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Tests\FeatureTestCase;

class ResizeImageJobTest extends FeatureTestCase
{
    public function testResizeImageWhenPathIsNull()
    {
        $manipulateImageService = $this->getManipulateImageService();
        $result = $this->getService(null)->handle($manipulateImageService);
        $this->assertFalse($result);
    }

    /**
     * @dataProvider urls
     */
    public function testResizeImageWhenPathIsUrl()
    {
        $manipulateImageService = $this->getManipulateImageService();
        $result = $this->getService('http://www.google.com')->handle($manipulateImageService);
        $this->assertFalse($result);
    }

    public function testResizeImage()
    {
        $image = UploadedFile::fake()->image('testimage.jpg', 2000, 2000);
        $storage = Storage::fake('public');
        $path = $storage->put('images', $image);
        Storage::disk('public')->assertExists($path);;
        $metadata = Image::make(Storage::disk('public')->get($path))->exif();
        $this->assertEquals(2000, $metadata['COMPUTED']['Height']);
        $this->assertEquals(2000, $metadata['COMPUTED']['Width']);
        $oldFileSize = $metadata['FileSize'];

        $manipulateImageService = $this->getManipulateImageService();
        $result = $this->getService($path)->handle($manipulateImageService);

        $metadata = Image::make(Storage::disk('public')->get($path))->exif();
        $this->assertEquals(600, $metadata['COMPUTED']['Height']);
        $this->assertEquals(600, $metadata['COMPUTED']['Width']);
        $this->assertTrue($metadata['FileSize'] < $oldFileSize);

        $this->assertTrue($result);
    }

    public function urls(): array
    {
        return [
            ['http://www.abx.com'],
            ['https://www.abx.com'],
            ['http://abx.com'],
            ['abx.com'],
            ['www.abx.com']
        ];
    }

    private function getManipulateImageService(): ModifyImageService
    {
        return App::make(ModifyImageService::class);
    }

    private function getService(?string $path): ResizeImageJob
    {
        return new ResizeImageJob($path);
    }
}
