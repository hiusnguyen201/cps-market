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
            'phone' => ['required', 'string', 'min:10', 'max:15', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})\b/'],
            'email' => 'required|string|max:150|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ":attribute invalid",
            'name.max' => ":attribute have invalid length characters",
            'phone.required' => ':attribute is required',
            'phone.string' => ":attribute invalid",
            'phone.min' => ":attribute have invalid length characters",
            'phone.max' => ":attribute have invalid length characters",
            'phone.regex' => ':attribute must be vietnamese phone number',
            'email.required' => ":attribute is required",
            'email.string' => ":attribute invalid",
            'email.max' => ":attribute have invalid length characters",
            'email.email' => ":attribute invalid",
            'password.required' => ':attribute is required',
            'password.string' => ':attribute invalid',
            'password.confirmed' => ':attribute is not match',
            'password_confirmation.required' => ':attribute is required',
            'password_confirmation.string' => ':attribute invalid',
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
