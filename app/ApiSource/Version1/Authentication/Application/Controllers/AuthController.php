<?php

namespace App\ApiSource\Version1\Authentication\Application\Controllers;

use App\ApiSource\Version1\Authentication\Domain\Login\LoginBusinessLogic;
use App\ApiSource\Version1\Authentication\Domain\Logout\LogoutBusinessLogic;
use App\ApiSource\Version1\Authentication\Domain\Register\RegisterBusinessLogic;
use App\ApiSource\Version1\Authentication\Domain\RequestLoginCode\RequestLoginCodeBusinessLogic;
use App\ApiSource\Version1\Authentication\Domain\SocialLogin\SocialLoginBusinessLogic;
use App\ApiSource\Version1\Authentication\Application\Requests\LoginRequest;
use App\ApiSource\Version1\Authentication\Application\Requests\LogoutRequest;
use App\ApiSource\Version1\Authentication\Application\Requests\RegisterRequest;
use App\ApiSource\Version1\Authentication\Application\Requests\RequestLoginCodeRequest;
use App\ApiSource\Version1\Authentication\Application\Requests\SocialLoginRequest;
use App\ApiSource\Version1\Exception\GenericException;
use App\ApiSource\Version1\User\Application\Resources\UserPrivateResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(
        RegisterRequest $request,
        RegisterBusinessLogic $registerBusinessLogic
    ): JsonResponse {
        $registerBusinessLogic->register($request->username, $request->email);

        return $this->response(
            [],
            __('v1/auth.registration.registered_successfully')
        );
    }

    public function login(
        LoginRequest $request,
        LoginBusinessLogic $loginBusinessLogic
    ): JsonResponse {
        try {
            $data = $loginBusinessLogic->login(
                $request->username,
                $request->password,
                $request->device_id
            );
            $user = (new UserPrivateResource($data['user']))->toArray($request);
            $responseData = [
                'token' => $data['token'],
                'token_id' => $data['token_id']
            ];
            $responseData = array_merge($responseData, $user);
            return $this->response($responseData);
        } catch (GenericException $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    public function requestLoginCode(
        RequestLoginCodeRequest $request,
        RequestLoginCodeBusinessLogic $requestLoginCodeBusinessLogic
    ): JsonResponse {
        try {
            $requestLoginCodeBusinessLogic->request($request->username);
        } catch (ModelNotFoundException $exception) {
            //do nothing
        } catch (Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }

        return $this->response(
            [],
            __('v1/auth.request_login_code.login_code_sent')
        );
    }

    public function logout(
        LogoutRequest $request,
        LogoutBusinessLogic $logoutBusinessLogic
    ): JsonResponse {
        $logoutBusinessLogic->logout((int)$request->token_id, Auth::id());

        return $this->response([]);
    }

    public function socialLogin(
        SocialLoginRequest $request,
        SocialLoginBusinessLogic $socialLoginBusinessLogic
    ) {
        $socialLogin = $socialLoginBusinessLogic->login(
            $request->social_site,
            $request->external_id,
            $request->name,
            empty($request->profile_photo) ? null : $request->profile_photo
        );

        return $this->response(
            [
                'username' => $socialLogin->user->getUsername()
            ]
        );
    }
}
