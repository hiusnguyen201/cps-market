<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;

class CartController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();
        $products = Product::all();

        $countProductInCart = 0;
        foreach ($carts as $cart) {
            $countProductInCart += $cart->quantity;
        }

        return view("customer/cart", [
            'title' => "Cart",
            'carts' => $carts,
            'products' => $products,
            "categories" => $categories,
            "countProductInCart" => $countProductInCart
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
            $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();


            if ($product->quantity <= 0 || ($cart && $cart->quantity > $product->quantity)) {
                return redirect()->back()->with('error', 'Not enough quantity available');
            }

            if (!$cart) {
                Cart::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => 1,
                ]);
            } else {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                ]);
            }

            if ($request->action == 'buy') {
                return redirect("/cart")->with('success', 'Add product to cart successfully');
            } else {
                return redirect()->back()->with('success', 'Add product to cart successfully');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return redirect()->back()->with('error', 'Add product to cart failed');
        }
    }

    public function handleUpdate(Request $request)
    {
        try {
            $cart = Cart::find($request->cart_id);

            if (!$cart) {
                return redirect()->back()->with('error', 'Cart not found!');
            }

            if ($request->quantity > $cart->product->quantity) {
                return redirect()->back()->with('error', 'Not enough quantity available');
            }

            $cart->update([
                "quantity" => $request->quantity,
                "updated_at" => now()
            ]);

            session()->flash("success", "Update quantity successfully");
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Update quantity unsuccessfully!');
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $cart = Cart::where(["user_id" =>  Auth::id(), "id" => $request->cart_id]);

            if (!$cart) {
                return redirect()->back()->with("error", "Cart not found!");
            }

            $cart->delete();

            session()->flash('error', 'Remove product from cart successfully!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Remove product from cart unsuccessfully!');
        }

        return redirect()->back();
    }
}
