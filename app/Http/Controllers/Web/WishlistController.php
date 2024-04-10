<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Services\WishlistService;
use App\Services\CategoryService;

class WishlistController extends Controller
{
    private WishlistService $wishlistService;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->wishlistService = new WishlistService();
        $this->categoryService = new CategoryService();
    }

    public function home()
    {
        $user = Auth::user();

        $countProductInCart = 0;
        foreach ($user->carts as $cart) {
            $countProductInCart += $cart->quantity;
        }

        $categories = $this->categoryService->findAll();
        $wishlist = $this->wishlistService->findAllByCustomerId($user->id);

        return view("customer/wishlist", [
            'title' => "Wishlist",
            "categories" => $categories,
            'wishlist' => $wishlist,
            'countProductInCart' => $countProductInCart,
        ]);
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|min:1|exists:products,id',
        ]);

        try {
            $this->wishlistService->add($request, Auth::id());
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