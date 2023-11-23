<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordResetRequest extends FormRequest
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
     * Determine validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
			'token' => ['required'],
			'password' => ['required', 'string', 'confirmed', 'max:255'],
			'email' => ['required', 'email', 'max:255', 'exists:users,email']
        ];
    }

    /**
     * Determine error messages for defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // messages will be translated in lang/ja/validation.php
        ];
    }
}
