<?php

namespace App\Http\Requests\Auth;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'phone' => 'required|string|digits_between:10,13|unique:users',
            'email' => 'required|string|max:100|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ":attribute invalid",
            'name.max' => ":attribute have invalid length characters",
            'phone.required' => ':attribute is required',
            'phone.integer' => ":attribute invalid",
            'phone.max' => ":attribute have invalid length characters",
            'email.required' => ":attribute is required",
            'email.string' => ":attribute invalid",
            'email.max' => ":attribute have invalid length characters",
            'email.email' => ":attribute invalid",
            'password.required' => ':attribute is required',
            'password_confirmation.required' => ':attribute is required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => "Name",
            'phone' => 'Phone',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation'
        ];
    }
}
