<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',

        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute is required',
            'email.email' => ':attribute invalid',
            'email.exists' => ':attribute not found',
        ];
    }

    public function attributes()
    {
        return [
            'email' => "Email",
        ];
    }
}