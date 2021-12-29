<?php

namespace Tests\Unit\ApiSource\Version1\Authentication\Domain\Login;

use App\ApiSource\Version1\Authentication\Domain\Login\LoginBusinessLogic;
use App\ApiSource\Version1\Authentication\Infra\Login\Services\GetUserService;
use App\ApiSource\Version1\Authentication\Infra\Login\Services\ResetPasswordService;
use App\ApiSource\Version1\Authentication\Infra\Login\Services\UpdatePersonalAccessTokenService;
use App\ApiSource\Version1\Exception\GenericException;
use App\Models\User;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use Tests\TestCase;

class LoginBusinessLogicTest extends TestCase
{
    private $getUserService;
    private $resetPasswordService;
    private $updatePersonalAccessTokenService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getUserService = $this->mock(GetUserService::class);
        $this->resetPasswordService = $this->mock(ResetPasswordService::class);
        $this->updatePersonalAccessTokenService = $this->mock(UpdatePersonalAccessTokenService::class);
    }

    protected function tearDown(): void
    {
        $this->getUserService = null;
        $this->resetPasswordService = null;
        $this->updatePersonalAccessTokenService = null;
        parent::tearDown();
    }

    public function testWhenUserIsNull()
    {
        $this->expectException(GenericException::class);
        $this->expectExceptionMessage('User with that username not found.');
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $this->mockGetUserService(null);
        $this->getService()->login('testuser', 'pass', 'xxx');
    }

    public function testWhenPasswordDoesNotMatch()
    {
        $this->expectException(GenericException::class);
        $this->expectExceptionMessage('Invalid login code. Request another one.');
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $user = new User();
        $user->setPassword('balbla');
        $this->mockGetUserService($user);
        $this->getService()->login('testuser', 'pass', 'xxx');
    }

    private function mockGetUserService(?User $return)
    {
        $this->getUserService =
            $this->mock(
                GetUserService::class,
                function (MockInterface $mock) use ($return) {
                    $mock->shouldReceive('getUser')
                        ->with('testuser')
                        ->once()
                        ->andReturn($return);
                }
            );
    }

    private function getService(): LoginBusinessLogic
    {
        return new LoginBusinessLogic(
            $this->getUserService,
            $this->resetPasswordService,
            $this->updatePersonalAccessTokenService,
        );
    }
}
