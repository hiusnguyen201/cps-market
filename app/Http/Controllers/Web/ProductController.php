<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product_Images;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::all();

        return view('admin.products.home', [
            'products' => $products,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Products']],
            'title' => 'Manage Products'
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', [
            'categories' => $categories,
            'breadcumbs' => [
                'titles' => ['Products', 'Create'],
                'title_links' => ["/admin/products"]
            ],
            'title' => 'Create Product',
        ]);
    }

    public function handleCreate(ProductRequest $request)
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

            session()->flash("success", "Create product successfully");
        } catch (\Exception $err) {
            session()->flash("error", "Create product failed");
        }

        return redirect()->back();
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', [
            'categories' => $categories,
            'product' => $product,
            'breadcumbs' => [
                'titles' => ['Products', 'Edit'],
                'title_links' => ["/admin/products"]
            ],
            'title' => 'Edit Product',
        ]);
    }

    public function details(Product $product)
    {
        return view('admin.products.details', [
            'product' => $product,
            'breadcumbs' => [
                'titles' => ['Products', 'Details'],
                'title_links' => ["/admin/products"]
            ],
            'title' => 'Details Product',
        ]);
    }
}
