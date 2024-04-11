<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\CategoryService;
use App\Services\WishlistService;
use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\UserService;

class HomeController extends Controller
{
    private CategoryService $categoryService;
    private BrandService $brandService;
    private WishlistService $wishlistService;
    private ProductService $productService;
    private UserService $userService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->wishlistService = new WishlistService();
        $this->productService = new ProductService();
        $this->userService = new UserService();
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

        if (Auth::user()) {
            [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        }

        return view("customer/home", [
            'sections' => $sections,
            'sections9D' => $sections9D,
            'sections9W' => $sections9W,
            'sections9M' => $sections9M,
            'categories' => $categories,
            'countProductsInCart' => $countProductsInCart,
            'title' => "Home"
        ]);
    }

    public function details($categorySlug, $brandSlug, $productSlug)
    {
        $product = $this->productService->findOneBySlug($productSlug);

        $wishlistCheck = null;
        if (Auth::user()) {
            $wishlistCheck = $this->wishlistService->findOneByProductIdAndCustomerId($product->id, Auth::id());
            [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        }

        $categories = $this->categoryService->findAll();

        return view('customer.products.details', [
            'product' => $product,
            'categories' => $categories,
            'countProductsInCart' => $countProductsInCart,
            'wishlistCheck' => $wishlistCheck,
            'title' => 'Details Product',
        ]);
    }

    public function search(Request $request)
    {
        $categories = $this->categoryService->findAll();
        $brands = $this->brandService->findAll();
        $products = $this->productService->searchProductWithFilterInCustomer($request);

        if (Auth::user()) {
            [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        }

        return view('customer.search', [
            'title' => 'Search Product',
            'countProductsInCart' => $countProductsInCart,
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'wishlistUser' => Auth::user()->wishlist,
        ]);
    }
}