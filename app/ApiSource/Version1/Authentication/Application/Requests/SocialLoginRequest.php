<?php

namespace App\ApiSource\Version1\Authentication\Application\Requests;

use App\Models\SocialLogin;
use Illuminate\Foundation\Http\FormRequest;

class SocialLoginRequest extends FormRequest
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
            'social_site' => ['required', 'in:' . implode(',', SocialLogin::getSocialSites())],
            'external_id' => ['required'],
            'name' => ['required'],
            'profile_photo' => ['nullable'],
        ];
    }
}
