<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        return view("customer/home", [
            'sections' => $sections,
            'sections9D' => $sections9D,
            'sections9W' => $sections9W,
            'sections9M' => $sections9M,
            'categories' => $categories,
            'countProductInCart' => $countProductInCart,
            'title' => "Home"
        ]);
    }

    public function details($categorySlug, $brandSlug, $productSlug)
    {
        $product = Product::where(['slug' => $productSlug])->first();
        $categories = Category::all();

        $countProductInCart = 0;
        $wishlistCheck = null;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }

            $wishlistCheck = Wishlist::where('product_id', $product->id)->where('user_id', Auth::id())->first();
        }

        return view('customer.products.details', [
            'product' => $product,
            'categories' => $categories,
            'countProductInCart' => $countProductInCart,
            'wishlistCheck' => $wishlistCheck,
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

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        return view('customer.products.categories', [
            'title' => 'Categories Product',
            'countProductInCart' => $countProductInCart,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function search(Request $request)
    {
        $categories = Category::all();

        $wishlists = Wishlist::where('user_id', Auth::id())->pluck('product_id', 'id')->toArray();
        $products = Product::where('name', 'like', '%' . $request->keyword . '%');

        $per_page = $request->per_page ?? 12;
        $sort_by = $request->sort_by ?? 'newest';

        if ($request->sort_by) {
            switch ($sort_by) {
                case 'newest':
                    $products = $products->orderByDesc('created_at');
                    break;

                case 'latest':
                    $products = $products->orderBy('created_at');
                    break;

                case 'lowest_price':
                    $products = $products->orderBy('price');
                    break;

                case 'highest_price':
                    $products = $products->orderByDesc('price');
                    break;

                default:
                    # code...
                    break;
            }
        }

        $price_min = $request->price_min;
        $price_max = $request->price_max;

        if ($price_min > $price_max) {
            $temp = $price_min;
            $price_min = $price_max;
            $price_max = $temp;
        }

        if (!empty($price_min)) {
            $products->where('price', '>=', $price_min);
        }

        if (!empty($price_max)) {
            $products->where('price', '<=', $price_max);
        }

        $products_brands = $products->get();

        $brands = [];
        foreach ($products_brands as $product_brand) {
            if (!isset($brands[$product_brand->brand_id])) {
                $brands[$product_brand->brand_id] = $product_brand->brand->name;
            }
        }

        // dd($brands);

        $products = $products->paginate($per_page);

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        return view('customer.search', [
            'title' => 'Search Product',
            'countProductInCart' => $countProductInCart,
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'per_page' => $per_page,
            'sort_by' => $sort_by,
            'price_min' => $price_min,
            'price_max' => $price_max,

            'wishlists' => $wishlists,
        ]);
    }
}