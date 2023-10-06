<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
			'src' => ['required', 'image', 'max:2048'],
			'post_name' => ['string', 'max:2200'],
			'post_content' => ['string', 'max:2200']
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
