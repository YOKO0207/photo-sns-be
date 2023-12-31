<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserNameUpdateRequest extends FormRequest
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
			'name' => ['required', 'string', 'max:255'],
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
