<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use PhpParser\Node\Expr\Cast\Object_;

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
                . (strtolower($request->_method) == 'patch' ? ',' . $request->id : ''),
            'market_price' => "required|integer|min:1",
            'price' => "required|integer|min:1",
            'sale_price' => "nullable|integer|min:1",
            'quantity' => "required|integer|min:0",
            'description' => "max:3000",
            "category" => 'required|integer|min:1|exists:categories,id',
            "brand" => 'required|integer|min:1|exists:brands,id',
            "promotion_image" => [
                'required',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:10000',
            ],
            "product_images" => "array|max:7",
            "product_images.*" => [
                'image',
                'mimes:jpeg,png,jpg',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:10000',
            ],
            "attribute_ids" => "array",
            "attribute_ids.*" => "required|integer|min:1",
            "attribute_values" => "array",
            "attribute_values.*" => "nullable|string|max:300",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ":attribute is required",
            'name.string' => ":attribute is invalid",
            'name.min' => ":attribute must have minimum length is :min",
            'name.max' => ":attribute must have maximum length is :max",
            'name.unique' => ":attribute is existed",
            'market_price.required' => ":attribute is required",
            'market_price.integer' => ":attribute is invalid",
            'market_price.min' => ":attribute is invalid",
            'price.required' => ":attribute is required",
            'price.integer' => ":attribute is invalid",
            'price.min' => ":attribute is invalid",
            'sale_price.required' => ":attribute is required",
            'sale_price.integer' => ":attribute is invalid",
            'sale_price.min' => ":attribute is invalid",
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
            "product_images.max" => ":attribute is invalid",
            "product_images.*.image" => ":attribute must be image in position :position",
            "product_images.*.mimes" => ":attribute must be image in position :position",
            "product_images.*.mimetypes" => ":attribute must be image in position :position",
            "product_images.*.max" => ":attribute exceeds :max KB in position :position",
            "attribute_ids.array" => ":attribute is invalid",
            "attribute_ids.*.required" => ":attribute is required in position :position",
            "attribute_ids.*.integer" => ":attribute is not found in position :position",
            "attribute_ids.*.min" => ":attribute is not found in position :position",
            "attribute_ids.*.exists" => ":attribute is not found in position :position",
            "attribute_values.array" => ":attribute is invalid",
            "attribute_values.*.string" => ":attribute is invalid",
            "attribute_values.*.max" => ":attribute has invalid length, max is :max",
        ];
    }
    public function attributes()
    {
        return [
            "name" => "Name",
            "market_price" => "Market Price",
            "price" => "Price",
            "sale_price" => "Sale price",
            "quantity" => "Quantity",
            "category" => "Category",
            "brand" => "Brand",
            "description" => "Description",
            "promotion_image" => "Promotion image",
            "product_images" => "Product images",
            "product_images.*" => "Product images",
            "attribute_ids" => "Attribute",
            "attribute_ids.*" => "Attribute",
            "attribute_values" => "Attribute value",
            "attribute_values.*" => "Attribute value",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}