<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        $sections = [];
        $categories = Category::all();

        for ($i = 0; $i < count($categories); $i++) {
            $categoryName = $categories[$i]->name;
            $products = Product::whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', $categoryName);
            })
                ->orderBy('sold', 'desc')
                ->limit(10)
                ->get();

            array_push($sections, $products);
        }

        //best sold in day
        $sections9D = Product::whereDate('updated_at', today())
            ->orderBy('sold', 'desc')
            ->limit(3)
            ->get();

        //best sold in week
        $sections9W = Product::whereYear('updated_at', now()->year)
            ->whereBetween('updated_at', [Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()])
            ->orderBy('sold', 'desc')
            ->limit(3)
            ->get();

        //best sold in month
        $sections9M = Product::whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->orderBy('sold', 'desc')
            ->limit(3)
            ->get();

        return view("customer/home", [
            'sections' => $sections,
            'sections9D' => $sections9D,
            'sections9W' => $sections9W,
            'sections9M' => $sections9M,
            'categories' => $categories,
            'title' => "Home"
        ]);
    }

    public function details($categorySlug, $brandSlug, $productSlug)
    {
        $product = Product::where(['slug' => $productSlug])->first();
        $categories = Category::all();

        return view('customer.products.details', [
            'product' => $product,
            'categories' => $categories,
            'title' => 'Details Product',
        ]);
    }


    public function categories($categorySlug, Request $request)
    {
        $categories = Category::all();
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $kw = $request->keyword;
        $products = Product::where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
        });

        $products = Product::where('category_id', $category->id)
            ->orderBy('sold', 'desc');

        $products = $products->paginate($request->limit ?? 9);
        return view('customer.products.categories', [
            'title' => 'Categories Product',
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}