<?php

namespace Tests\Unit\ApiSource\Version1\Authentication\Domain\Register;

use App\ApiSource\Version1\Authentication\Domain\Register\RegisterBusinessLogic;
use App\ApiSource\Version1\Authentication\Infra\Register\Services\RegisterUserService;
use App\ApiSource\Version1\User\Infra\Identicon\Services\GenerateIdenticonService;
use App\Models\User;
use Mockery\MockInterface;
use Tests\TestCase;

class RegisterBusinessLogicTest extends TestCase
{
    private $registerUserService;
    private $generateIdenticonService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registerUserService = $this->mock(RegisterUserService::class);
        $this->generateIdenticonService = $this->mock(GenerateIdenticonService::class);
    }

    protected function tearDown(): void
    {
        $this->registerUserService = null;
        $this->generateIdenticonService = null;
        parent::tearDown();
    }

    public function testWhenProfilePhotoIsNull()
    {
        $this->mockGenerateIdenticonService();
        $this->mockRegisterUserService();

        $this->getService()->register(
            'username',
            'email',
            null,
            'password',
            true
        );
    }

    public function testWhenProfilePhotoIsNotNull()
    {
        $this->mockRegisterUserService();

        $this->getService()->register(
            'username',
            'email',
            'path-to-profile-picture',
            'password',
            true
        );
    }

    private function mockGenerateIdenticonService()
    {
        $this->generateIdenticonService =
            $this->mock(
                GenerateIdenticonService::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('generateIdenticon')
                        ->with(
                            'username',
                        )
                        ->once()
                        ->andReturn('path-to-profile-picture');
                }
            );
    }

    private function mockRegisterUserService()
    {
        $this->registerUserService =
            $this->mock(
                RegisterUserService::class,
                function (MockInterface $mock) {
                    $mock->shouldReceive('register')
                        ->with(
                            'username',
                            'email',
                            'path-to-profile-picture',
                            'password',
                            true
                        )
                        ->once()
                        ->andReturn(new User());
                }
            );
    }

    private function getService(): RegisterBusinessLogic
    {
        return new RegisterBusinessLogic(
            $this->generateIdenticonService,
            $this->registerUserService,
        );
    }
}
