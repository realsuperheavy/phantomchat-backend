<?php

namespace App\ApiSource\Version1\User\Application\Controllers;

use App\ApiSource\Version1\User\Domain\DeleteUser\DeleteUserBusinessLogic;
use App\ApiSource\Version1\User\Domain\SearchUser\SearchUserBusinessLogic;
use App\ApiSource\Version1\User\Domain\UpdateUser\UpdateUserBusinessLogic;
use App\ApiSource\Version1\User\Application\Requests\SearchUserRequest;
use App\ApiSource\Version1\User\Application\Requests\UpdateUserRequest;
use App\ApiSource\Version1\User\Application\Resources\UserPrivateResource;
use App\ApiSource\Version1\User\Application\Resources\UserPublicResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getByUsername(string $username): UserPublicResource
    {
        try {
            $user = User::where('username', $username)->firstOrFail();
            return new UserPublicResource($user);
        } catch (ModelNotFoundException $e) {
            abort(Response::HTTP_NOT_FOUND, __('v1/user.user_not_found'));
        }
    }

    public function getMe(): UserPrivateResource
    {
        $user = Auth::user();
        return new UserPrivateResource($user);
    }

    public function update(
        UpdateUserRequest $request,
        UpdateUserBusinessLogic $updateUserBusinessLogic
    ): UserPrivateResource {
        $user = $updateUserBusinessLogic->update(
            Auth::id(),
            $request->username
        );
        return new UserPrivateResource($user);
    }

    public function delete(
        DeleteUserBusinessLogic $deleteUserBusinessLogic
    ): JsonResponse {
        $deleteUserBusinessLogic->delete(Auth::id());
        return $this->response([], __('v1/user.account_deleted'));
    }

    public function search(
        SearchUserRequest $request,
        SearchUserBusinessLogic $searchUserBusinessLogic
    ): JsonResource {
        $users = $searchUserBusinessLogic->search($request->username, Auth::id());
        return UserPublicResource::collection($users);
    }
}
