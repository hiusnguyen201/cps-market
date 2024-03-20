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

    public function handleCreate(Request $request)
    {
        if ($user = Auth::user()) {

            $product = Product::findOrFail($request->product_id);

            $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

            if (!$cart) {
                Cart::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);

                return response()->json(['message' => 'Product added to cart successfully']);
            } else {
                $productQty = $product->quantity;
                $cartQty = $cart->quantity;

                if ($cartQty < $productQty) {
                    $cart->update([
                        'quantity' => $cart->quantity + 1,
                        'price' => $cart->price + $product->price,
                    ]);

                    return response()->json(['message' => 'Product quantity updated in cart']);
                } else {

                    return response()->json(['error' => 'Not enough quantity available']);
                }
            }
        } else {
            return response()->json(['error' => 'If you are not logged in, click <a href="/auth/login">here</a> to login'], 401);
        }
    }

    public function handleUpdate(Request $request)
    {
        if ($user = Auth::user()) {

            $cart = Cart::findOrFail($request->cart_id);

            $product = Product::findOrFail($cart->product_id);

            $action = $request->action;

            if ($action === 'increase') {
                if ($cart) {
                    $product = Product::findOrFail($cart->product_id);

                    $cart->update([
                        'quantity' => $cart->quantity + 1,
                        'price' => $cart->price + $product->price,
                    ]);
                }
            } else {
                if ($cart->quantity == 1) {
                    $this->handleDelete($cart->id);
                } else {
                    $cart->update([
                        'quantity' => $cart->quantity - 1,
                        'price' => $cart->price - $product->price,
                    ]);
                }
            }

            return response()->json(['message' => 'Cart updated successfully']);
        } else {
            return response()->json(['error' => 'Unable to update cart'], 400);
        }
    }

    public function handleDelete(Request $request)
    {
        if ($user = Auth::user()) {
            $cart = Cart::findOrFail($request->cart_id);

            if ($cart) {

                if ($user->id == $cart->user_id) {
                    $cart->delete();
                    return response()->json(['message' => 'Product removed from cart successfully'], 400);
                } else {
                    return response()->json(['error' => 'Product removed from cart error'], 400);
                }
            } else {
                return response()->json(['error' => 'Product removed from cart error'], 400);
            }

        } else {
            return response()->json(['error' => 'Unable to update cart'], 400);
        }
    }

}
