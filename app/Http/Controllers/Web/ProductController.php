<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product_Attribute;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Images;

class ProductController extends Controller
{
    public function home(Request $request)
    {
        $kw = $request->keyword;

        $products = Product::where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
        });

        if ($request->category) {
            $products = $products->where("category_id", $request->category);
        }

        $products = $products->paginate($request->limit ?? 10);

        $categories = Category::all();

        return view('admin.products.home', [
            'products' => $products,
            "categories" => $categories,
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

    public function edit(Product $product)
    {
        $categories = Category::all();
        $attributes = Attribute::whereHas('specification', function ($query) use ($product) {
            $query->where('category_id', $product->category_id);
        })->get();

        return view('admin.products.edit', [
            'categories' => $categories,
            'product' => $product,
            'attributes' => $attributes,
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

    public function handleDelete(Request $request)
    {
        try {
            $ids = is_array($request->id) ?  $request->id : [$request->id];

            foreach ($ids as $index => $id) {
                $product = Product::find($id);
                if (!$product) throw new ModelNotFoundException;

                foreach ($product->images as $image) {
                    $folder_path = explode("/", $image->thumbnail)[0];
                    if (Storage::directoryExists("public/" . $folder_path)) {
                        Storage::deleteDirectory("public/" . $folder_path);
                        break;
                    }
                }

                Product_Images::where("product_id", $product->id)->delete();
                Product_Attribute::where("product_id", $product->id)->delete();

                $product->delete();
                session()->flash('success', 'Delete product successfully');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete product failed');
        }

        return redirect()->back();
    }
}