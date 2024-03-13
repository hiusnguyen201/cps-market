<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email' . ($request->id ? ',' . $request->id : ''),
            'phone' => ['required', 'string', 'min:10', 'max:15', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})\b/'],
            'gender' => 'integer',
            'role' => 'required|integer',
            'address' => 'max:150',
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
