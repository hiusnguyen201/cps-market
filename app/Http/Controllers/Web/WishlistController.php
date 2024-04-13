<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Services\WishlistService;
use App\Services\CategoryService;
use App\Services\UserService;

class WishlistController extends Controller
{
    private WishlistService $wishlistService;
    private CategoryService $categoryService;
    private UserService $userService;

    public function __construct()
    {
        $this->wishlistService = new WishlistService();
        $this->categoryService = new CategoryService();
        $this->userService = new UserService();
    }

    public function home()
    {
        $categories = $this->categoryService->findAll();
        $wishlist = $this->wishlistService->findAllByCustomerId(Auth::id());
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());

        return view("customer/wishlist", [
            'title' => "Wishlist",
            "categories" => $categories,
            'wishlist' => $wishlist,
            'countProductsInCart' => $countProductsInCart ?? 0,
        ]);
    }

    public function handleCreate(Request $request)
    {
        try {
            $this->wishlistService->add($request->product_id, Auth::id());
            session()->flash('success', 'Add product to wishlist successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $this->wishlistService->delete($request->wishlist_id, Auth::id());
            session()->flash('success', 'Remove product from wishlist successfully!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}