<?php

namespace App\Http\Requests\Admin;

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
            'category' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ':attribute Invalid ',
            'name.max' => ':attribute have invalid length characters',
            'role.required' => ':attribute is required',
            'role.integer' => ':attribute invalid',
        ];
    }
    public function attributes()
    {
        return [
            'name' => "Name",
            'category' => "Category",
        ];
    }
}
