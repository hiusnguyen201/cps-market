<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product_Images;

class ProductController extends Controller
{
    public function home(Request $request)
    {
        $products = Product::all();

        return view('admin.products.home', [
            'products' => $products,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Products']],
            'title' => 'Manage products'
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
            'title' => 'Create product'
        ]);
    }

    public function handleCreate(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'market_price' => $request->market_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
            ]);

            $promotion_path = $request->file('promotion_image')->store('public');
            Product_Images::create([
                'thumbnail' => $promotion_path,
                'product_id' => $product->id,
                'pin' => 1
            ]);

            $product_images = $request->file('product_images');

            if ($product_images && count($product_images) > 0) {
                foreach ($product_images as $image) {
                    $product_path = $image->store('public');
                    Product_Images::create([
                        'thumbnail' => $product_path,
                        'product_id' => $product->id,
                    ]);
                }
            }

            DB::commit();
            session()->flash("error", "Create product successfully");
        } catch (\Exception $err) {
            DB::rollback();
            session()->flash("error", "Create product failed");
        }

        return redirect()->back();
    }
}
