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
            if ($i > 5) break;
            $products = $this->productService->findAllWithLimitByCategoryName(10, $categories[$i]->name);
            array_push($sections, $products);
        }

        $sections9Y = $this->productService->findAllWithLimitBestSoldInYear(3);
        $sections9W = $this->productService->findAllWithLimitBestSoldInWeek(3);
        $sections9M = $this->productService->findAllWithLimitBestSoldInMonth(3);

        $wishlist = null;
        if (Auth::user()) {
            $wishlist = $this->wishlistService->findAllByCustomerId(Auth::id());
            [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        }

        return view("customer/home", [
            'sections' => $sections,
            'sections9Y' => $sections9Y,
            'sections9W' => $sections9W,
            'sections9M' => $sections9M,
            'categories' => $categories,
            'wishlist' => $wishlist,
            'countProductsInCart' => $countProductsInCart ?? 0,
            'title' => "Home"
        ]);
    }

    public function details($categorySlug, $brandSlug, $productSlug)
    {
        $product = $this->productService->findOneBySlug($productSlug);
        if (!$product) {
            return \abort(404);
        }

        $wishlist = null;
        if (Auth::user()) {
            $wishlist = $this->wishlistService->findAllByCustomerId(Auth::id());
            [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        }

        $categories = $this->categoryService->findAll();
        $similarProducts = $this->productService->getSimilarProductsWithLimit($product->brand_id, 6);

        return view('customer.products.details', [
            'product' => $product,
            'categories' => $categories,
            'countProductsInCart' => $countProductsInCart ?? 0,
            'wishlist' => $wishlist,
            'title' => 'Details Product',
            'similarProducts' => $similarProducts
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
            'countProductsInCart' => $countProductsInCart ?? 0,
            'countProducts' => $products->count(),
            'products' => $products->paginate($request->per_page ?? 8),
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
