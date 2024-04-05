<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|different:current_password',
            'new_password_confirmation' => 'required|string|min:8|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'The :attribute field is required.',

            'new_password.required' => 'The :attribute field is required.',
            'new_password.min' => 'The :attribute must be at least :min characters.',
            'new_password.different' => 'The :attribute must be different from the current password.',

            'new_password_confirmation.required' => 'The :attribute field is required.',
            'new_password_confirmation.min' => 'The :attribute must be at least :min characters.',
            'new_password_confirmation.same' => 'The :attribute and New Password must match.',
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'new_password_confirmation' => 'Password Confirmation'
        ];
    }
}
