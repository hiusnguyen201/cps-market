<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $userStatusValues = array_column(config("constants.user_status"), 'value');
        $genderValues = array_column(config("constants.genders"), 'value');

        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email' . ($request->_method == 'PATCH' ? ',' . $request->id : ''),
            'phone' => ['required', 'string', 'min:10', 'max:15', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})\b/'],
            'gender' => ['nullable', 'integer', Rule::in($genderValues)],
            'status' => ['required', "integer", Rule::in($userStatusValues)],
            'address' => "nullable|string|max:150"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ':attribute Invalid ',
            'name.max' => ':attribute has invalid length characters',
            'email.required' => ':attribute is required',
            'email.email' => ':attribute Invalid ',
            'email.max' => ':attribute has invalid length characters',
            'email.unique' => ':attribute was registered',
            'phone.required' => ':attribute is required',
            'phone.string' => ':attribute invalid',
            'phone.min' => ':attribute has invalid length characters',
            'phone.max' => ':attribute has invalid length characters',
            'phone.regex' => ':attribute must be vietnamese phone number',
            'gender.integer' => ':attribute invalid',
            'gender.in' => ':attribute invalid',
            'address.string' => ':attribute invalid',
            'address.max' => ':attribute has invalid length characters',
        ];
    }
    public function attributes()
    {
        return [
            'name' => "Name",
            'email' => "Email",
            'phone' => 'Phone',
            'gender' => "Gender",
            'status' => "Status",
            'address' => "Address",
        ];
    }
}