<?php

namespace App\ApiSource\Version1\PushToken\Application\Controllers;

use App\ApiSource\Version1\PushToken\Domain\SavePushToken\SavePushTokenBusinessLogic;
use App\ApiSource\Version1\PushToken\Application\Requests\SavePushTokenRequest;
use App\Http\Controllers\Controller;
use App\Models\PushToken;
use Illuminate\Support\Facades\Auth;

class PushTokenController extends Controller
{
    public function create(
        SavePushTokenRequest $request,
        SavePushTokenBusinessLogic $savePushTokenBusinessLogic
    ) {
        $savePushTokenBusinessLogic->save(
            $request->device_id,
            $request->platform,
            $request->token,
            $request->token_type ?? PushToken::TOKEN_TYPE_FIREBASE,
            Auth::id()
        );
        return $this->response([]);
    }
}
