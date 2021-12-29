<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function response(array $data, ?string $message = null): JsonResponse
    {
        return response()->json(
            [
                'data' => $data,
                'message' => $message,
            ]
        );
    }

    /**
     * @param JsonResource $resource
     */
    protected function responseResource(
        object $resource,
        ?string $message = null
    ): JsonResource {
        return $resource->additional(['message' => $message]);
    }
}
