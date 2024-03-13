<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|min:4|max:150|unique:products,name'
                . ($request->id ? ',' . $request->id : ''),
            'price' => "required|integer|min:1",
            'market_price' => "required|integer|min:1",
            'quantity' => "required|integer|min:0",
            'description' => "max:3000",
            "category" => 'required|integer|min:1|exists:categories,id',
            "brand" => 'required|integer|min:1|exists:brands,id',
            "promotion_image" => [
                'required',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            "product_images" => "array",
            "product_images.*" => [
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ":attribute is required",
            'name.string' => ":attribute is invalid",
            'name.min' => ":attribute is invalid",
            'name.max' => ":attribute is invalid",
            'name.unique' => ":attribute is existed",
            'price.required' => ":attribute is required",
            'price.integer' => ":attribute is invalid",
            'price.min' => ":attribute is invalid",
            'market_price.required' => ":attribute is required",
            'market_price.integer' => ":attribute is invalid",
            'market_price.min' => ":attribute is invalid",
            'description.max' => ":attribute has invalid length, max is :max",
            'quantity.required' => ":attribute is required",
            'quantity.integer' => ":attribute is invalid",
            'quantity.min' => ":attribute is invalid",
            'category.required' => ":attribute is required",
            'category.integer' => ":attribute is not found",
            'category.min' => ":attribute is not found",
            'category.exists' => ":attribute is not found",
            'brand.required' => ":attribute is required",
            'brand.integer' => ":attribute is not found",
            'brand.min' => ":attribute is not found",
            'brand.exists' => ":attribute is not found",
            "promotion_image.required" => ":attribute is required",
            "promotion_image.image" => ":attribute must be image",
            "promotion_image.mimes" => ":attribute must be image",
            "promotion_image.mimetypes" => ":attribute must be image",
            "promotion_image.max" => ":attribute exceeds :max KB",
            "product_images.array" => ":attribute is invalid",
            "product_images.*.image" => ":attribute must be image",
            "product_images.*.mimes" => ":attribute must be image",
            "product_images.*.mimetypes" => ":attribute must be image",
            "product_images.*.max" => ":attribute exceeds :max KB",
        ];
    }
    public function attributes()
    {
        return [
            "name" => "Name",
            "price" => "Price",
            "market_price" => "Market price",
            "quantity" => "Quantity",
            "category" => "Category",
            "brand" => "Brand",
            "description" => "Description",
            "promotion_image" => "Promotion image",
            "product_images" => "Product images"
        ];
    }
}
