<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\Product;


class WishlistController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $user = Auth::user();
        $wishlists = Wishlist::where('user_id', $user->id)->get();
        $products = Product::all();
        $countProductInCart = 0;

        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        return view("customer/wishlist", [
            'title' => "Wishlist",
            'wishlists' => $wishlists,
            'products' => $products,
            "categories" => $categories,
            'countProductInCart' => $countProductInCart,
        ]);
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|min:1|exists:products,id',
        ]);

        try {
            $user = Auth::user();
            $product = Product::find($request->product_id);

            Wishlist::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
            ]);

            session()->flash('success', 'Add product to wishlist successfully');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Add product to wishlist failed');
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $wishlist = Wishlist::where(["user_id" => Auth::id(), "id" => $request->wishlist_id]);

            if (!$wishlist) {
                return redirect()->back()->with("error", "Wishlist not found!");
            }

            $wishlist->delete();

            session()->flash('success', 'Remove product from wishlist successfully!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Remove product from wishlist unsuccessfully!');
        }

        return redirect()->back();
    }
}