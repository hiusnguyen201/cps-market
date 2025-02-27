<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:150',
            'customer_phone' => ['required', 'string', 'min:10', 'max:15', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})\b/'],
            "province" => "required|integer",
            "district" => "required|integer",
            "ward" => "nullable|integer",
            "address" => "required|string|max:100",
            "note" => "nullable|string|max:100",
            "payment_method" => "required|integer|min:0",
        ];
    }

    public function messages()
    {
        return [
            "customer_name.required" => ":attribute is required",
            "customer_name.string" => ":attribute is invalid",
            'customer_name.max' => ':attribute has a maximum of :max characters',
            'customer_email.required' => ':attribute is required',
            'customer_email.email' => ':attribute is invalid',
            'customer_email.max' => ':attribute has a maximum of :max characters',
            'customer_phone.required' => ':attribute is required',
            'customer_phone.string' => ':attribute invalid',
            'customer_phone.min' => ':attribute has at least :min characters',
            'customer_phone.max' => ':attribute has a maximum of :max characters',
            'customer_phone.regex' => ':attribute must be vietnamese phone number',
            'province.required' => ':attribute is required',
            'province.integer' => ':attribute is invalid',
            'district.required' => ':attribute is required',
            'district.integer' => ':attribute is invalid',
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
            "customer_name" => "Name",
            "customer_email" => "Email",
            "customer_phone" => "Phone",
            "province" => "Province",
            "district" => "District",
            "ward" => "Ward",
            "address" => "Address",
            "note" => "Note",
            "payment_method" => "Payment method",
        ];
    }
}