<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique("specifications")->where(function ($query) use ($request) {
                    return $query->where("name", $request->name)->where("category_id", $request->category_id)->where("id", "!=", $request->specification_id);
                })
            ],
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|string|max:150',
            'category_id' => 'required|integer|min:1|exists:categories,id',
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
            'attributes.*.string' => ':attribute invalid in position :position',
            'attributes.*.max' => ':attribute invalid length in position :position',
            'category_id.required' => ':attribute is required',
            'category_id.integer' => ':attribute is not found',
            'category_id.min' => ':attribute is not found',
            'category_id.exists' => ':attribute not is found',
        ];
    }
    public function attributes()
    {
        return [
            'name' => "Name",
            'attributes' => "Attributes",
            'attributes.*' => "Attribute",
            'category' => 'Category',
        ];
    }
}