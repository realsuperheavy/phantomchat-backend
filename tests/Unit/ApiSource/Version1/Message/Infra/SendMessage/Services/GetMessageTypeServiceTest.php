<?php

namespace Tests\Unit\ApiSource\Version1\Message\Infra\SendMessage\Services;

use App\ApiSource\Version1\Message\Infra\SendMessage\Services\GetMessageTypeService;
use App\Models\Message;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GetMessageTypeServiceTest extends TestCase
{

    public function testGetImageMessageType()
    {
        $result = $this->getService()
            ->getMessageType(
                UploadedFile::fake()->create('test.jpg', 1),
                null
            );

        $this->assertEquals(Message::TYPE_IMAGE, $result);
    }


    public function testGetVideoMessageType()
    {
        $result = $this->getService()
            ->getMessageType(
                UploadedFile::fake()->create('test.mp4', 1),
                null
            );

        $this->assertEquals(Message::TYPE_VIDEO, $result);
    }


    public function testGetGifMessageType()
    {
        $result = $this->getService()
            ->getMessageType(
                null,
                'https://media.giphy.com/media/stqfN7Rp5pl8DW9Lc2/giphy.gif'
            );

        $this->assertEquals(Message::TYPE_GIF, $result);
    }

    public function testGetTextMessageType()
    {
        $result = $this->getService()
            ->getMessageType(
                null,
                null
            );

        $this->assertEquals(Message::TYPE_TEXT, $result);
    }

    private function getService(): GetMessageTypeService
    {
        return new GetMessageTypeService();
    }
}
