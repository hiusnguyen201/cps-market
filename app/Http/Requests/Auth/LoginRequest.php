<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|max:100|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ":attribute is required",
            'email.string' => ":attribute invalid",
            'email.max' => ":attribute have invalid length characters",
            'email.email' => ":attribute invalid",
            'password.required' => ':attribute is required'
        ];
    }

    public function attributes()
    {
        return [
            'email' => "Email",
            'password' => 'Password'
        ];
    }
}
