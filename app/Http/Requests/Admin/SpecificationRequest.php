<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SpecificationRequest extends FormRequest
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
            'name' => 'required|string|max:150|unique:specifications,name' . ($request->_method == 'PATCH' ? ',' . $request->id : ''),
            'attributes' => 'array',
            'category.*id' => 'integer|min:1|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'name.string' => ':attribute Invalid ',
            'name.max' => ':attribute have invalid length characters',
            'name.unique' => ':attribute is existed',
            'attributes.array' => ':attribute invalid',
            'category.*.integer' => ':attribute is not found',
            'category.*.min' => ':attribute is not found',
            'category.*.exists' => ':attribute not is found',
        ];
    }
    public function attributes()
    {
        return [
            'name' => "Name",
            'attributes' => "Attributes",
            'category' => 'Category',
        ];
    }
}