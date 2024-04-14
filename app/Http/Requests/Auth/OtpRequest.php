<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
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
            'otp' => 'required|min:6|max:10'
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => ':attribute is required',
            'otp.min' => ':attribute invalid',
            'otp.max' => ':attribute invalid'
        ];
    }

    public function attributes()
    {
        return [
            'otp' => 'Otp',
        ];
    }
}