<?php

namespace Tests\Unit\ApiSource\Version1\Message\Infra\SendMessage\Services;

use App\ApiSource\Version1\ImageModification\Infra\ModifyImage\Services\ModifyImageService;
use App\ApiSource\Version1\Message\Infra\SendMessage\Services\UploadMediaService;
use App\Models\Message;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image as InterventionImage;
use Mockery\MockInterface;
use Tests\TestCase;

class UploadMediaServiceTest extends TestCase
{
    private $manipulateImageService;


    protected function setUp(): void
    {
        parent::setUp();
        $this->manipulateImageService = $this->mock(ModifyImageService::class);
    }

    protected function tearDown(): void
    {
        $this->manipulateImageService = null;
        parent::tearDown();
    }

    public function testWhenImageFileIsUploaded()
    {
        $knownDate = Carbon::create(2021, 12, 29);
        Carbon::setTestNow($knownDate);

        Storage::fake('public');
        $this->mockManipulateImageService();
        $file = UploadedFile::fake()->create('image.jpg', 2);

        $result = $this->getService()->upload(
            Message::TYPE_IMAGE,
            $file,
            null
        );

        Storage::disk('public')->assertExists('post-media/2021-12-29/' . $file->hashName());
        $this->assertEquals('post-media/2021-12-29/' . $file->hashName(), $result);
    }

    public function testWhenImageVideoIsUploaded()
    {
        $knownDate = Carbon::create(2021, 12, 29);
        Carbon::setTestNow($knownDate);

        Storage::fake('public');
        $file = UploadedFile::fake()->create('video.mp4', 2);

        $result = $this->getService()->upload(
            Message::TYPE_VIDEO,
            $file,
            null
        );

        Storage::disk('public')->assertExists('post-media/2021-12-29/' . $file->hashName());
        $this->assertEquals('post-media/2021-12-29/' . $file->hashName(), $result);
    }

    public function testWhenFileUrlIsPassed()
    {
        $knownDate = Carbon::create(2021, 12, 29);
        Carbon::setTestNow($knownDate);

        $result = $this->getService()->upload(
            Message::TYPE_VIDEO,
            null,
            'https://media.giphy.com/media/bUyNEbEglZg41CMw6y/giphy.gif'
        );

        $this->assertEquals('https://media.giphy.com/media/bUyNEbEglZg41CMw6y/giphy.gif', $result);
    }

    private function mockManipulateImageService(): void
    {
        $this->manipulateImageService = $this->mock(
            ModifyImageService::class,
            function (MockInterface $mock) {
                $mock
                    ->shouldReceive('createImage')
                    ->once()
                    ->andReturn($this->getOrientateMock());
            }
        );
    }

    private function getOrientateMock(): MockInterface
    {
        return $this->mock(
            ModifyImageService::class,
            function (MockInterface $mock) {
                $mock
                    ->shouldReceive('orientate')
                    ->once()
                    ->andReturn($this->getImageMock());
            }
        );
    }

    private function getImageMock(): MockInterface
    {
        return $this->mock(
            ModifyImageService::class,
            function (MockInterface $mock) {
                $mock
                    ->shouldReceive('getImage')
                    ->once()
                    ->andReturn($this->getSaveImageMock());
            }
        );
    }

    private function getSaveImageMock(): MockInterface
    {
        return $this->mock(
            InterventionImage::class,
            function (MockInterface $mock) {
                $mock
                    ->shouldReceive('save')
                    ->once();
            }
        );
    }

    private function getService(): UploadMediaService
    {
        return new UploadMediaService(
            $this->manipulateImageService
        );
    }
}
