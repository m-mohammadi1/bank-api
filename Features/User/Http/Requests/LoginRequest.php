<?php

namespace Features\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone_number' => ['required', 'exists:users'],
            'password' => ['required']
        ];
    }
}
