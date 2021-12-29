<?php

namespace App\ApiSource\Version1\Message\Application\Controllers;

use App\ApiSource\Version1\Exception\GenericException;
use App\ApiSource\Version1\Message\Application\Requests\SendMessageRequest;
use App\ApiSource\Version1\Message\Application\Resources\MessageResource;
use App\ApiSource\Version1\Message\Domain\SendMessage\SendMessageBusinessLogic;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MessageController
{
    public function send(
        SendMessageRequest $request,
        SendMessageBusinessLogic $sendMessageBusinessLogic
    ): MessageResource {
        try {
            $message = $sendMessageBusinessLogic->send(
                Auth::id(),
                (int)$request->conversation_id,
                Carbon::createFromFormat('Y-m-d H:i:s', $request->sent_at_local_time),
                $request->body,
                $request->file_url,
                $request->file,
            );
            return new MessageResource($message);
        } catch (GenericException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }
}
