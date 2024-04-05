<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\Product_Attribute;
use App\Models\Attribute;
use Illuminate\Support\Facades\Crypt;
use App\Models\Product_Images;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function create(ProductRequest $request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'slug' => Str::slug($request->name, '-'),
            ]);

            $encrypted_id = Crypt::encryptString($product->id);
            $promotion_image_path = $encrypted_id . "/" . $request->file('promotion_image')->hashName();
            $request->file('promotion_image')->storeAs('public', $promotion_image_path);
            Product_Images::create([
                'thumbnail' => "storage/" . $promotion_image_path,
                'product_id' => $product->id,
                'pin' => 1
            ]);

            $product_images = $request->file('product_images');
            if ($product_images && count($product_images) > 0) {
                foreach ($product_images as $image) {
                    $product_image_path = $encrypted_id . "/" . $image->hashName();
                    $image->storeAs('public', $product_image_path);
                    Product_Images::create([
                        'thumbnail' => "storage/" . $product_image_path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            foreach($request->attribute_ids as $index => $id) {
                $attribute = Attribute::find($id);
                if($request->attribute_values[$index]) {
                    Product_Attribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $request->attribute_values[$index]
                    ]);
                }
            }

            return response()->json([
                'message' => 'Create product successfully',
                'data' => $product,
            ], 200);
        } catch (\Exception $err) {
            error_log($err);
            return response()->json([
                'message' => 'Server Error',
                'error' => $err
            ], 500);
        }
    }


    public function update(Product $product, ProductRequest $request)
    {
        try {
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'slug' => Str::slug($request->name, '-'),
                'updated_at' => now()
            ]);

            // Delete folder images of product
            foreach ($product->images as $image) {
                $folder_path = explode("/", $image->thumbnail)[0];
                if (Storage::directoryExists("public/" . $folder_path)) {
                    Storage::deleteDirectory("public/" . $folder_path);
                    break;
                }
            }

            // Delete product image 
            Product_Images::where("product_id", $product->id)->delete();
            // Delete value attributes
            Product_Attribute::where("product_id", $product->id)->delete();

            // Create product images
            $encrypted_id = Crypt::encryptString($product->id);
            $promotion_image_path = $encrypted_id . "/" . $request->file('promotion_image')->hashName();
            $request->file('promotion_image')->storeAs('public', $promotion_image_path);
            Product_Images::create([
                'thumbnail' => "storage/" . $promotion_image_path,
                'product_id' => $product->id,
                'pin' => 1
            ]);

            $product_images = $request->file('product_images');
            if ($product_images && count($product_images) > 0) {
                foreach ($product_images as $image) {
                    $product_image_path = $encrypted_id . "/" . $image->hashName();
                    $image->storeAs('public', $product_image_path);
                    Product_Images::create([
                        'thumbnail' => "storage/" . $product_image_path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            foreach($request->attribute_ids as $index => $id) {
                $attribute = Attribute::find($id);
                if($request->attribute_values[$index]) {
                    Product_Attribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $request->attribute_values[$index]
                    ]);
                }
            }

            return response()->json([
                'message' => 'Update product successfully',
                'data' => $product,
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $err
            ], 500);
        }
    }
}