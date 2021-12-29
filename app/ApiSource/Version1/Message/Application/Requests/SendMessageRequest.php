<?php

namespace App\ApiSource\Version1\Message\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'conversation_id' => ['required', 'exists:conversations,id'],
            'message_hash' => ['required', 'string'],
            'sent_at_local_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'file_url' => ['nullable'],
            'file' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif'],
            'body' => ['nullable', 'max:2000',
                Rule::requiredIf(function () {
                    return $this->file === null && $this->file_url === null;
                })
            ]
        ];
    }
}
