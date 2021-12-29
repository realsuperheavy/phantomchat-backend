<?php

namespace App\ApiSource\Version1\Authentication\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'unique:users,email', 'max:100', 'min:3'],
            'username' => ['required', 'unique:users,username', 'max:100'],
        ];
    }
}
