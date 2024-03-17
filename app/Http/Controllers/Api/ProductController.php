<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use App\Models\Product_Images;

class ProductController extends Controller
{
    public function create(ProductRequest $request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'market_price' => $request->market_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
            ]);

            $encrypted_id = Crypt::encryptString($product->id);
            $promotion_image_path = $encrypted_id . "/" . $request->file('promotion_image')->hashName();
            $request->file('promotion_image')->storeAs('public', $promotion_image_path);
            Product_Images::create([
                'thumbnail' => $promotion_image_path,
                'product_id' => $product->id,
                'pin' => 1
            ]);

            $product_images = $request->file('product_images');
            if ($product_images && count($product_images) > 0) {
                foreach ($product_images as $image) {
                    $product_image_path = $encrypted_id . "/" . $image->hashName();
                    $image->storeAs('public', $product_image_path);
                    Product_Images::create([
                        'thumbnail' => $product_image_path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Create product successfully',
                'data' => $product,
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'Create product failed',
            ], 500);
        }
    }
}
