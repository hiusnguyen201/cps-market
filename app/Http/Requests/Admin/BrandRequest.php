<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'name' => 'required|string|max:100',
            'role' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ':attribute Invalid ',
            'name.max' => ':attribute have invalid length characters',
            'email.required' => ':attribute is required',
            'email.email' => ':attribute Invalid ',
            'email.max' => ':attribute have invalid length characters',
            'email.unique' => ':attribute was registered',
            'phone.required' => 'Phone is required',
            'phone.string' => ':attribute invalid',
            'phone.min' => ':attribute have invalid length characters',
            'phone.max' => ':attribute have invalid length characters',
            'phone.regex' => ':attribute must be vietnamese phone number',
            'gender.required' => ':attribute is required',
            'gender.integer' => ':attribute invalid',
            'role.required' => ':attribute is required',
            'role.integer' => ':attribute invalid',
            'address.max' => ':attribute have invalid length characters',
        ];
    }
    public function attributes()
    {
        return [
            'name' => "Name",
            'email' => "Email",
            'phone' => 'Phone',
            'gender' => "Gender",
            'role' => "Role",
            'address' => "Address"
        ];
    }
}
