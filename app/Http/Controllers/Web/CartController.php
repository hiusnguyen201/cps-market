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
        $user = Auth::user();

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if (!$cart && $product) {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);

            return redirect()->back()->with('success', 'ADD');
        } else {

            if ($cart->quantity < $product->quantity) {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                    'price' => $cart->price + $product->price,
                ]);

                return redirect()->back()->with('success', 'ADD qty');
            } else {
                return redirect()->back()->with('error', 'Not enough quantity available');
            }
        }
    }

    public function handleUpdate(Request $request)
    {
        $user = Auth::user();

        $cart = Cart::findOrFail($request->cart_id);
        $product = Product::findOrFail($cart->product_id);

        if ($cart && $product) {
            if ($request->quantity > $cart->quantity) { //tang sl
                if ($cart->quantity >= $product->quantity) { //kt so luong kho hang
                    return redirect()->back()->with('error', 'Not enough QTY');
                } else {
                    $cart->update([
                        'quantity' => $request->quantity,
                        'price' => $request->quantity * $product->price,
                    ]);
                    return redirect()->back()->with('success', 'Updated');
                }
            } else { // giam sl
                if ($cart->quantity == 1) {
                    $this->handleDelete($request->cart_id);
                    return redirect()->back()->with('success', 'Updated');
                } else {
                    $cart->update([
                        'quantity' => $request->quantity,
                        'price' => $request->quantity * $product->price,
                    ]);
                    return redirect()->back()->with('success', 'Updated');
                }
            }
        }
    }

    public function handleDelete(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::findOrFail($request->cart_id);

        if ($cart) {
            if ($user->id == $cart->user_id) {
                $cart->delete();
                return redirect()->back()->with('success', 'Updated');
            } else {
                return redirect()->back()->with('error', 'Not correct user');
            }
        } else {
            return redirect()->back()->with('error', 'Can not find cart');
        }
    }
}
