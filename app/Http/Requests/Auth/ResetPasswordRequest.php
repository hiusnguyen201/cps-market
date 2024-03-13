<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => "required"
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ':attribute is required',
            'password.min' => ':attribute needs at least 6 characters',
            'password.confirmed' => ':attribute and confirm password are not same',
            'password_confirmation.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'password' => "Password",
            'password_confirmation' => "Password Confirmation"

        ];
    }
}
