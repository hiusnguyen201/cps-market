<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function home()
    {

        if ($user = Auth::user()) {
            $carts = Cart::where('user_id', $user->id)->get();
            
            return view("customer/cart", [
                'title' => "Cart | Cps Market ",
                'carts' => $carts,
            ]);
        } else {
            return redirect('auth/login');
        }
    }

    public function handleCreate($product_id)
    {
        if ($user = Auth::user()) {
            $product = Product::findOrFail($product_id);

            $userCart = Cart::where('user_id', $user->id)->where('product_id', $product_id)->first();

            if (!$userCart) {
                Cart::create([
                    'product_id' => $product_id,
                    'user_id' => $user->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);

                return redirect()->back()->with('success', 'ADD');
            } else {
                $productQty = $product->quantity;
                $userCartQty = $userCart->quantity;

                if ($userCartQty < $productQty) {
                    $userCart->update([
                        'quantity' => $userCart->quantity + 1,
                        'price' => $userCart->price + $product->price,
                    ]);

                    return redirect()->back()->with('success', 'ADD');
                } else {

                    return redirect()->back()->with('error', 'Not enough QTY');
                }
            }
        } else {
            return redirect('auth/login');
        }
    }

    public function decreaseQuantity($product_id)
    {
        if ($user = Auth::user()) {
            $product = Product::findOrFail($product_id);
            $userCart = Cart::where('user_id', $user->id)->where('product_id', $product_id)->first();

            if ($userCart->quantity == 1) {
                $this->handleDelete($userCart->id);
            } else {
                $userCart->update([
                    'quantity' => $userCart->quantity - 1,
                    'price' => $userCart->price - $product->price,
                ]);
            }

            return redirect()->back();
        } else {
            return redirect('auth/login');
        }
    }

    public function handleDelete($cart_id)
    {
        if ($user = Auth::user()) {
            $userCart = Cart::findOrFail($cart_id);

            if ($userCart) {

                if ($user->id == $userCart->user_id) {
                    $userCart->delete();
                    return redirect()->back()->with('success', 'Product removed from cart successfully');
                } else {
                    return redirect()->back()->with('error', 'Product removed from cart error');
                }
            } else {
                return redirect()->back()->with('error', 'Product removed from cart error');
            }
        } else {
            return redirect('auth/login');
        }
    }

    public function checkout()
    {
        if ($user = Auth::user()) {
            // $carts = Cart::with('product')->where('user_id', $user->id)->get();

            return view("customer/checkout", [
                'title' => "Checkout | Cps Market ",
                // 'carts' => $carts
            ]);
        } else {
            return redirect('auth/login');
        }
    }

    public function handleCheckout(Request $request)
    {
        if ($user = Auth::user()) {
            // $carts = Cart::with('product')->where('user_id', $user->id)->get();

            return view("customer/checkout", [
                'title' => "Checkout | Cps Market ",
                // 'carts' => $carts
            ]);
        } else {
            return redirect('auth/login');
        }
    }
}
