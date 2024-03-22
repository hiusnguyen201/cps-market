<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        if ($user = Auth::user()) {
            // $carts = Cart::where('user_id', $user->id)->get();
            $carts = Cart::all();

            return response()->json($carts);
        }

        $carts = Cart::all();

        return response()->json($carts);
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', $request->user_id)->where('product_id', $product->id)->first();

        if (!$cart && $product) {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => $request->user_id,
                'quantity' => 1,
                'price' => $product->price,
            ]);

            return response()->json(['message' => 'Product added to cart successfully'], 200);
        } else {

            if ($cart->quantity < $product->quantity) {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                    'price' => $cart->price + $product->price,
                ]);

                return response()->json(['message' => 'Product quantity updated in cart'], 200);
            } else {

                return response()->json(['error' => 'Not enough quantity available'], 400);
            }
        }
    }

    public function handleUpdate(Request $request)
    {

        $cart = Cart::findOrFail($request->cart_id);
        $product = Product::findOrFail($cart->product_id);

        if ($cart && $product) {
            if ($request->action === 'increase' && $cart->quantity < $product->quantity) {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                    'price' => $cart->price + $product->price,
                ]);
                return response()->json(['message' => 'Cart updated successfully'], 200);
            }
            else {
                return response()->json(['error' => 'Not enough QTY'], 400);
            }
        } else {
            if ($cart->quantity == 1) {
                $this->handleDelete($cart->id);
                return response()->json(['message' => 'Cart updated successfully'], 200);
            } else {
                $cart->update([
                    'quantity' => $cart->quantity - 1,
                    'price' => $cart->price - $product->price,
                ]);
                return response()->json(['message' => 'Cart updated successfully'], 200);
            }
        }
    }

    public function handleDelete(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);

        if ($cart) {
            if ($request->user_id == $cart->user_id) {
                $cart->delete();
                return response()->json(['message' => 'Product removed from cart successfully'], 200);
            } else {
                return response()->json(['error' => 'Product removed from cart error'], 400);
            }
        } else {
            return response()->json(['error' => 'Product removed from cart error'], 404);
        }
    }
}
