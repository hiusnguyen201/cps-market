<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Product_Attribute;
use App\Models\Attribute;
use App\Models\Product_Images;

class ProductController extends Controller
{
    public function findProductByCode(Request $request)
    {
        if (!$request->code) {
            return response()->json([
                'message' => 'Code is required',
            ], 400);
        }

        $product = Product::where("code", $request->code)->with("images")->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        if ($product->quantity <= 0) {
            return response()->json([
                'message' => 'Product is out of stock',
            ], 400);
        }

        return response()->json([
            'message' => 'Success',
            'product' => $product
        ], 200);
    }

    public function create(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create([
                'code' => time(),
                'name' => $request->name,
                'price' => $request->price,
                'market_price' => $request->market_price,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'slug' => Str::slug($request->name, '-'),
            ]);

            $encrypted_id = Crypt::encryptString($product->id);
            $promotion_image_path =  $request->file('promotion_image')->hashName();
            $request->file('promotion_image')->storeAs('public', $promotion_image_path);
            Product_Images::create([
                'thumbnail' => "storage/" . $promotion_image_path,
                'product_id' => $product->id,
                'pin' => 1
            ]);

            $product_images = $request->file('product_images');
            if ($product_images && count($product_images) > 0) {
                foreach ($product_images as $image) {
                    $product_image_path =  $image->hashName();
                    $image->storeAs('public', $product_image_path);
                    Product_Images::create([
                        'thumbnail' => "storage/" . $product_image_path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            if ($request->attribute_ids) {
                foreach ($request->attribute_ids as $index => $id) {
                    $attribute = Attribute::find($id);
                    if ($request->attribute_values[$index]) {
                        Product_Attribute::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute->id,
                            'value' => $request->attribute_values[$index]
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Create product successfully',
                'data' => $product,
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'error' => "Create Product failed"
            ], 500);
        }
    }


    public function update(Product $product, ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product->update([
                'name' => $request->name,
                'market_price' => $request->market_price,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'slug' => Str::slug($request->name, '-'),
                'updated_at' => now()
            ]);


            if ($product->images && count($product->images)) {
                foreach ($product->images as $image) {
                    $path = explode("/", $image->thumbnail)[1];
                    if (Storage::exists("public/" . $path)) {
                        Storage::delete("public/" . $path);
                    }
                }
            }

            // Delete product image 
            Product_Images::where("product_id", $product->id)->delete();
            // Delete value attributes
            Product_Attribute::where("product_id", $product->id)->delete();

            // Create product images
            $promotion_image_path =  $request->file('promotion_image')->hashName();
            $request->file('promotion_image')->storeAs('public', $promotion_image_path);
            Product_Images::create([
                'thumbnail' => "storage/" . $promotion_image_path,
                'product_id' => $product->id,
                'pin' => 1
            ]);

            $product_images = $request->file('product_images');
            if ($product_images && count($product_images) > 0) {
                foreach ($product_images as $image) {
                    $product_image_path =  $image->hashName();
                    $image->storeAs('public', $product_image_path);
                    Product_Images::create([
                        'thumbnail' => "storage/" . $product_image_path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            if ($request->attribute_ids) {
                foreach ($request->attribute_ids as $index => $id) {
                    $attribute = Attribute::find($id);
                    if ($request->attribute_values[$index]) {
                        Product_Attribute::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute->id,
                            'value' => $request->attribute_values[$index]
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Edit product successfully',
                'data' => $product,
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'message' => 'Edit product failed',
            ], 500);
        }
    }
}
