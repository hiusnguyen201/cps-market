<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customer_id' => 'required|integer|min:1|exists:users,id',
            'product_id' => 'required|array',
            'product_id.*' => 'required|integer|min:1|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            "province" => "required|integer",
            "district" => "required|integer",
            "ward" => "required|integer",
            "address" => "required|string|max:100",
            "note" => "nullable|string|max:100",
            "payment_method" => "required|integer|min:0",
        ];
    }

    public function messages()
    {
        return [
            "customer_id.required" => ":attribute is required",
            "customer_id.integer" => ":attribute is not found",
            'customer_id.min' => ':attribute is not found',
            'customer_id.exists' => ':attribute is not found',
            'product_id.required' => ':attribute is required',
            'product_id.array' => ':attribute is invalid',
            'product_id.*.required' => ':attribute is required in position :position',
            'product_id.*.integer' => ':attribute is not found in position :position',
            'product_id.*.min' => ':attribute is not found in position :position',
            'product_id.*.exists' => ':attribute is not found in position :position',
            'quantity.required' => ':attribute is required',
            'quantity.array' => ':attribute is invalid',
            'quantity.*.required' => ':attribute is required in position :position',
            'quantity.*.integer' => ':attribute is invalid in position :position',
            'quantity.*.min' => ':attribute is invalid in position :position',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'province.required' => ':attribute is required',
            'province.integer' => ':attribute is invalid',
            'district.required' => ':attribute is required',
            'district.integer' => ':attribute is invalid',
            'ward.required' => ':attribute is required',
            'ward.integer' => ':attribute is invalid',
            'address.required' => ':attribute is required',
            'address.string' => ':attribute is invalid',
            'address.max' => ':attribute has a maximum of :max characters',
            'note.string' => ':attribute is invalid',
            'note.max' => ':attribute has a maximum of :max characters',
            'payment_method.required' => ':attribute is required',
            'payment_method.integer' => ':attribute is invalid',
            'payment_method.min' => ':attribute is invalid',
        ];
    }

    public function attributes()
    {
        return [
            "customer_id" => "Customer",
            "province" => "Province",
            "district" => "District",
            "product_id" => "Product",
            "product_id.*" => "Product",
            "quantity" => "Quantity",
            "quantity.*" => "Quantity",
            "ward" => "Ward",
            "address" => "Address",
            "note" => "Note",
            "payment_method" => "Payment method",
        ];
    }
}