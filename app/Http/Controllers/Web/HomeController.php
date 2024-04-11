<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\CategoryService;
use App\Services\WishlistService;
use App\Services\ProductService;
use App\Services\BrandService;

class HomeController extends Controller
{
    private CategoryService $categoryService;
    private BrandService $brandService;
    private WishlistService $wishlistService;
    private ProductService $productService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->wishlistService = new WishlistService();
        $this->productService = new ProductService();
    }

    public function home()
    {
        $sections = [];
        $categories = $this->categoryService->findAll();

        for ($i = 0; $i < count($categories); $i++) {
            $products = $this->productService->findAllWithLimitByCategoryName(10, $categories[$i]->name);
            array_push($sections, $products);
        }

        $sections9D = $this->productService->findAllWithLimitBestSoldInDay(3);
        $sections9W = $this->productService->findAllWithLimitBestSoldInWeek(3);
        $sections9M = $this->productService->findAllWithLimitBestSoldInMonth(3);

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
        $product = $this->productService->findOneBySlug($productSlug);

        $countProductInCart = 0;
        $wishlistCheck = null;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }

            $wishlistCheck = $this->wishlistService->findOneByProductIdAndCustomerId($product->id, Auth::id());
        }

        $categories = $this->categoryService->findAll();

        return view('customer.products.details', [
            'product' => $product,
            'categories' => $categories,
            'countProductInCart' => $countProductInCart,
            'wishlistCheck' => $wishlistCheck,
            'title' => 'Details Product',
        ]);
    }

    public function search(Request $request)
    {
        $categories = $this->categoryService->findAll();
        $brands = $this->brandService->findAll();

        $wishlistUser = Auth::user()->wishlist;
        $products = $this->productService->searchProductWithFilterInCustomer($request);

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
            'wishlistUser' => $wishlistUser,
        ]);
    }
}